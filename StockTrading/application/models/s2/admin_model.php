<?php
	class ADMIN_MODEL extends CI_Model {
		public function __construct(){
			$this->load->database();
		}


		//账户状态:0正常，1申请开户中，2申请挂失中 3申请补办中 4 申请销户中 5 已挂失 6 已销户 7 被锁住 8 开户失败

		//显示该证券经纪商名下托管的所有资金账户
		//显示的被托管账户必须是:正常，申请挂失中，申请补办中，申请销户中，被锁住
		//返回查询结果
		public function getAllaccounts($agid){
			$sql= "SELECT fid,sid,create_date,fa_status FROM fund_account WHERE agid= ? AND fa_status < ? OR fa_status= ? AND fa_status != ?";
			$query=$this->db->query($sql,array($agid,5,7,1));
			return $query;
		}

		//显示该证券经纪商名下托管的所有资金账户的明细
		//显示的被托管账户明细是通过超链接完成的
		//返回查询结果
		public function getDetailaccount($fid,$agid){
			$sql="SELECT fid,sid,idc,agid,fa_status,create_date FROM fund_account WHERE fid=? AND agid= ?";
			$query=$this->db->query($sql,array($fid,$agid));
			return $query;
		}

		//显示该证券经纪商所有未处理请求
		//未处理请求显示格式 类型、资金账户卡号、发送申请的日期、申请的流水号(通过超链接链接到明细)
		public function getAllrequests_nd($agid){
			$sql="SELECT types,fid,senddates,rid FROM request WHERE status= ? AND agid = ?";
			$query=$this->db->query($sql,array(0,$agid));
			return $query;
		}

		//显示该证券经纪商名下所有的未处理请求的明细
		//显示的请求明细是通过超链接完成的
		//返回查询结果
		public function getDetailreq($rid){
			$sql="SELECT types,fid,idc,senddates,rid FROM request WHERE rid= ?";
			$query=$this->db->query($sql,array($rid));
			return $query;
		}

		//显示该证券经纪商名下所有的已处理请求的明细
		//显示的请求明细是通过超链接完成的
		//返回查询结果
		public function getAllrequests_hd($agid){
			$sql="SELECT types,fid,senddates,dealdates,rid FROM request WHERE status= ? AND agid = ?";
			$query=$this->db->query($sql,array(1,$agid));
			return $query;
		}

		//获取该证券经纪商的所有操作日志
		public function getAlllog($agid){
			$sql='SELECT lgid,content,dates FROM admin_log WHERE agid = ?';
			$query=$this->db->query($sql,array($agid));
			return $query;
		}

		//修改管理员密码
		//先验证输入的管理员ID与原密码是否正确且匹配
		public function modKey($agid,$oldkey,$key){
			$sql='SELECT * FROM admin_account WHERE agid = ? AND agkey = ?';
			$query=$this->db->query($sql,array($agid,$oldkey));
			$reault=array();
			if($query->num_rows()==1){
				//用户名和密码匹配，修改密码，更新数据库条目
				$result['sql_error']='密码修改成功';
				$row=$query->row();
				$row->agkey=$key;
				$this->db->where('agid',$agid);
				$this->db->update('admin_account',$row);
			}else{
				//用户名和密码不匹配
				//报错
				$result['sql_error']='用户名或密码错误';
			}
			return $result;
		}

		//管理员做登陆操作时添加记录
		public function adLog($agid,$time){
			$data = array(
				'agid' => $agid ,
				'content' => '管理员登陆',
				'dates' => $time
			);
			$this->db->insert('admin_log',$data);
		}

		//管理员做登出操作时添加记录
		public function adLogout($agid){
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$data = array(
				'agid' => $agid ,
				'content' => '管理员登出',
				'dates' => $date
			);
			$this->db->insert('admin_log',$data);
		}

		//账户挂失
		//如果批准：1.在管理员操作记录中添加条目。2.修改账户状态为已挂失。3.将请求变为已处理
		//如果拒绝：1.在管理员操作记录中添加条目。2.修改账户状态为正常。3.将请求变为已处理
		//type=0 agree type=1 disagree
		public function adCheckloss($rid,$agid,$type,$fid,$reason){
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$con='针对账户：';
			$con.=$fid;
			if($type==0){
				$con.='批准';
			}else{
				$con.='拒绝';
			}
			$con.='挂失';
			$con=$con.'<br>  理由:'.$reason;
			$data = array(
				'agid' => $agid ,
				'content' => $con,
				'dates' => $date
			);
			$this->db->insert('admin_log',$data);

			if($type==0){
			//批准请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=5;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
			//fa_status=5
			}else{
			//拒绝请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=0;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
			//fa_status=0
			}

			//修改请求为已处理
			$sql='SELECT * FROM request WHERE rid = ?';
			$query=$this->db->query($sql,array($rid));
			$row=$query->row();
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$row->dealdates=$date;
			$row->status=1;
			$this->db->where('rid',$rid);
			$this->db->update('request',$row);
		}


		//账户开户
		//如果批准：1.在管理员操作记录中添加条目。2.修改账户状态为正常。3.将请求变为已处理
		//如果拒绝：1.在管理员操作记录中添加条目。2.修改账户状态为已拒绝开户。3.将请求变为已处理
		//type=0 agree type=1 disagree
		public function adCheckcreate($rid,$agid,$type,$fid,$reason){
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$con='针对账户：';
			$con.=$fid;
			if($type==0){
				$con.='批准';
			}else{
				$con.='拒绝';
			}
			$con.='开户';
			$con=$con.'<br>  理由:'.$reason;
			$data = array(
				'agid' => $agid ,
				'content' => $con,
				'dates' => $date
			);
			$this->db->insert('admin_log',$data);

			if($type==0){
			//批准请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=0;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
			//fa_status=0
			}else{
			//拒绝请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=8;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
			//fa_status=8
			}
			//修改请求为已处理
			$sql='SELECT * FROM request WHERE rid = ?';
			$query=$this->db->query($sql,array($rid));
			$row=$query->row();
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$row->dealdates=$date;
			$row->status=1;
			$this->db->where('rid',$rid);
			$this->db->update('request',$row);
		}


		//账户补办
		//如果批准：1.在管理员操作记录中添加条目。2.修改原账户状态为已挂失。3.生成新账户号
		//4.将原账户号与新账户号关联。5.将新账户号状态变为正常。6.将原账户号信息复制到新账户号上。
		//7.将资金信息中的原账户号用新账户号替换。8.将请求变为已处理
		//如果拒绝：1.在管理员操作记录中添加条目。2.修改账户状态正常。3.将请求变为已处理
		//type=0 agree type=1 disagree
		public function adCheckmakeup($rid,$agid,$type,$fid,$reason){
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$con='针对账户：';
			$con=$con.$fid;
			if($type==0){
				$con=$con.'批准';
			}else{
				$con=$con.'拒绝';
			}
			$con=$con.'补办';
			$con=$con.'<br>  理由:'.$reason;
			$data = array(
				'agid' => $agid ,
				'content' => $con,
				'dates' => $date
			);
			$this->db->insert('admin_log',$data);

			if($type==0){
			//批准请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=5;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
				//fa_status=5 complete loss


				//find the new account id
				$this->db->select_max('fid');
				$query=$this->db->get('fund_account');
				$find_newfid_row=$query->row();
				$find_newfid=$find_newfid_row->fid;

				//make up again
				$sql='SELECT idc,sid,login_pin,trade_pin,atm_pin,fa_status,agid,create_date FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=0;
				date_default_timezone_set("PRC");
				$row->create_date=date("Y-m-d H:i:s");
				$row->related_id=$find_newfid+1;
				$this->db->insert('fund_account',$row);

				$this->db->select_max('fid');
				$query=$this->db->get('fund_account');
				$find_newfid_row=$query->row();
				$find_newfid=$find_newfid_row->fid;

				//copy currency form old to new
				$sql='SELECT fid FROM currency WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$res=$query->num_rows();
				if($res>0){
					$row=$query->row();
					$row->fid=$find_newfid;
					$this->db->where('fid',$fid);
					$this->db->update('currency',$row);
				}

			}else{
			//拒绝请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=0;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
				//fa_status=0
			}

			//修改请求为已处理
			$sql='SELECT * FROM request WHERE rid = ?';
			$query=$this->db->query($sql,array($rid));
			$row=$query->row();
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$row->dealdates=$date;
			$row->status=1;
			$this->db->where('rid',$rid);
			$this->db->update('request',$row);
		}

		//账户补办
		//如果批准：1.在管理员操作记录中添加条目。2.修改原账户状态为已销户。3.通知系统结息
		//4.将请求变为已处理
		//如果拒绝：1.在管理员操作记录中添加条目。2.修改账户状态正常。3.将请求变为已处理
		//type=0 agree type=1 disagree
		public function adCheckcancel($rid,$agid,$type,$fid,$reason){
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$con='针对账户：';
			$con.=$fid;
			if($type==0){
				$con.='批准';
			}else{
				$con.='拒绝';
			}
			$con.='销户';
			$con=$con.'<br>  理由:'.$reason;
			$data = array(
				'agid' => $agid ,
				'content' => $con,
				'dates' => $date
			);
			$this->db->insert('admin_log',$data);

			if($type==0){
			//批准请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=6;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
				//fa_status=6
			}else{
			//拒绝请求
				$sql='SELECT * FROM fund_account WHERE fid = ?';
				$query=$this->db->query($sql,array($fid));
				$row=$query->row();
				$row->fa_status=0;
				$this->db->where('fid',$fid);
				$this->db->update('fund_account',$row);
				//fa_status=0
			}

			//修改请求为已处理
			$sql='SELECT * FROM request WHERE rid = ?';
			$query=$this->db->query($sql,array($rid));
			$row=$query->row();
			date_default_timezone_set("PRC");
			$date=date("Y-m-d H:i:s");
			$row->dealdates=$date;
			$row->status=1;
			$this->db->where('rid',$rid);
			$this->db->update('request',$row);
		}

		//检查这个账户是否存在
		public function hsAccount($ac){
			$sql='SELECT * FROM fid = ?';
			$query=$this->db->query($sql,array($ac));
			if($query->num_rows()==1) return TRUE;
			else return FALSE;
		}

		//获得单个资金账户的所有操作记录
		//根据$fid返回
		public function getSinglelog($fid){
			$sql='SELECT * FROM fund_log WHERE fid = ?';
			$query=$this->db->query($sql,array($fid));
			return $query;
		}

		//获得单个资金账户的所有操作日志
		//根据$fid返回
		public function getSinglereq($fid){
			$sql='SELECT * FROM request WHERE fid = ? AND status = ?';
			$query=$this->db->query($sql,array($fid,0));
			return $query;
		}

		//管理员查询用户具体账户情况时检查用户账户内资金情况
		// 0 人民币  1 美元  2 港币      3 欧元      4 英镑
		// 5 日元    6 澳元  7 加拿大元  8 瑞士法郎  9 新加坡元
		public function getCurrencyDetail($fid){
			//在资金表中查询信息
			$sql='SELECT amount,frozen,available,types FROM currency WHERE fid=?';
			$query=$this->db->query($sql,array($fid));
			if($query->num_rows()>0){
				return $query;
			}else{
				return false;
			}
		}

		//从证券经济商id得到名字
		public function getAgentname($agid){
			switch($agid){
				case 000001:return '中信证券';
				case 000002:return '光大证券';
				case 000003:return '国信证券';
				case 000004:return '华泰证券';
				case 000005:return '广发证券';
				case 000006:return '海通证券';
				default:return false;
			}
		}
	}
?>
