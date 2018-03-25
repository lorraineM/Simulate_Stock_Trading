<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Interest_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function cal_interest($fid)
    {
        $query = $this->db->get_where('currency',array('fid' => $fid)); //选出fid所对应的币种
        foreach ($query->result() as $row)
        {
            $num = $row->types;       // 得到该币种的序号
            $this->db->select('interest_rate');  // 查询该币种的利率
            $this->db->where(array('currency' => $num));
            $q2 = $this->db->get('rate');
            $irate = $q2->first_row();      // 得到该币种的利率
            $amount  = $row->product * $irate->interest_rate * 0.01 / 360 + $row->interest;
            // 利息=利息积数*利率/360+利息         利息全部转换为本金
            $data = array(                    // 更新本金，可用资金，利息，利息积数
               'amount' => $row->amount + $amount,
               'available' => $row->available + $amount,
               'interest' => 0,
               'product' => 0
            );
            $this->db->where(array('fid' => $row->fid, 'types' => $row->types));
            $this->db->update('currency', $data);        # 更新
        }
        return $query;
    }
}

/* End of file interest_model.php */
/* Location: ./application/models/interest_model.php */
