<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Interest_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function cal_interest($fid)
    {
        $query = $this->db->get_where('currency',array('fid' => $fid)); //ѡ��fid����Ӧ�ı���
        foreach ($query->result() as $row)
        {
            $num = $row->types;       // �õ��ñ��ֵ����
            $this->db->select('interest_rate');  // ��ѯ�ñ��ֵ�����
            $this->db->where(array('currency' => $num));
            $q2 = $this->db->get('rate');
            $irate = $q2->first_row();      // �õ��ñ��ֵ�����
            $amount  = $row->product * $irate->interest_rate * 0.01 / 360 + $row->interest;
            // ��Ϣ=��Ϣ����*����/360+��Ϣ         ��Ϣȫ��ת��Ϊ����
            $data = array(                    // ���±��𣬿����ʽ���Ϣ����Ϣ����
               'amount' => $row->amount + $amount,
               'available' => $row->available + $amount,
               'interest' => 0,
               'product' => 0
            );
            $this->db->where(array('fid' => $row->fid, 'types' => $row->types));
            $this->db->update('currency', $data);        # ����
        }
        return $query;
    }
}

/* End of file interest_model.php */
/* Location: ./application/models/interest_model.php */
