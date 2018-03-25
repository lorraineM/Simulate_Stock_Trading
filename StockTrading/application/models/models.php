<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Models extends CI_Model {


    function Models()
    {
        parent::__construct();
        $this->load->database();
    }

    function status_query($account='',$trade_password='',$atm_password='')
    {
        $this->db->select('fa_status');
        $this->db->where('fid =',$account);
        $this->db->where('trade_pin =',$trade_password);
        $this->db->where('atm_pin =',$atm_password);
        $this->db->from('fund_account');
        $query = $this->db->get();
        $fa_status=-1;
        foreach($query->result() as $row)
        {
            $fa_status=$row->fa_status;
        }
        return $fa_status;
    }

    function related_id_query($account='')
    {
        $this->db->select('related_id');
        $this->db->where('fid =',$account);
        $this->db->from('fund_account');
        $query = $this->db->get();
        $related_id=0;
        foreach($query->result() as $row)
        {
            $related_id=$row->related_id;
        }
        return $related_id;
    }

    function deposit_save_password($account='',$password='')
    {
        $this->db->select('fa_status');
        $this->db->where('fid =',$account);
        $this->db->where('atm_pin =',$password);
        $this->db->from('fund_account');
        $query = $this->db->get();
        $fa_status=-1;//如果返回结果为-1.说明账户密码出错
        foreach($query->result() as $row)
        {
            $fa_status=$row->fa_status;
        }
        return $fa_status;
    }

    function admin_login_password($account='',$password='')
    {
        $query=$this->db->get("admin_account");
        foreach($query->result() as $row)
        {
            if($row->agid==$account&&$row->agkey==$password)
                return true;
        }
        return false;
    }

    function currency_exist($account='',$type='')
    {
        $this->db->select('fid,types');
        $this->db->where('fid =',$account);
        $this->db->where('types =',$type);
        $this->db->from('currency');
        $query =$this->db->get();
        foreach($query->result() as $row)
        {
            return true;
        }
        return false;
    }
    function query_fund_info($account='')
    {
        return $this->db->query("select fid, available, frozen , amount, types from currency where fid = $account  order by types");
    }

    function save_or_deposit($account='',$amount='',$save_or_deposit='',$type='')
    {
        
        if($save_or_deposit=="save"){
            if($this->currency_exist($account,$type))
            {
                $this->db->query("update currency set amount=amount+$amount,available=available+$amount where fid = $account and types = $type");
                return true;
            }
            else
            {
                $data=array(
                'fid'=>$account,
                'types'=>$type,
                'amount'=>$amount,
                'available'=>$amount
                );
                $this->db->insert('currency',$data);
                return true;
            }
        }
        else
        {
            $query=$this->db->query("select available from currency where fid = $account and types = $type");
            $available=0;
            foreach($query->result() as $row)
            {
                $available=$row->available;
            }
            if($available>$amount)
            {
                $this->db->query("update amount=amount-$amount,available=available-$amount from currency where fid = $account and types = $type");
                return true;
            }
            else 
            {
                return false;
            }
        }
    }

    function add_fund_log($fid='',$content='',$types='')
    {
        $data=array(
            'fid'=>$fid,
            'content'=>$content,
            'types'=>$types
            );
        $this->db->insert('fund_log',$data);
    }

    function add_admin_log($agid='',$content='')
    {
        $data=array(
            'agid'=>$agid,
            'content'=>$content
            );
        $this->db->insert('admin_log',$data);

    }

}

/* End of file test_model.php */
/* Location: ./application/models/test_model.php */
