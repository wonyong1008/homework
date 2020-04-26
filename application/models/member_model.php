<?php
class Member_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->load->database();
    }


    public function signUp($data = null) {
        $sql = "
            insert member set 
                userName = ?
                , nickname = ?
                , passwd = ?
                , phone = ?
                , email = ?
                , gender = ?
                , lastLoginDt = NOW()
                , regDt = NOW()
        ";
        $this->db->query($sql, $data);
        $res = $this->db->insert_id();
        return $res;
    }

    public function login($email, $passwd) {
        $sql = "
            select 
                * 
            from member
            where
                email = ?
        ";
        
        $query = $this->db->query($sql, array($email));
        
        $row = $query->row();
        
        if($row) {
           
            if($row->passwd == $passwd) {
                //로그인성공
                $dataSession = array();
                
                $dataSession['userSession'] = array(
                    'userName'  => $row->userName,
                    'nickname'  => $row->nickname,
                    'email'     => $row->email
                );
                $this->session->set_userdata($dataSession);
                return true;
            } else {
                //패스워드 불일치
                return false;
            }
        } else {
            //아이디 없음
            return false;
        }
        return $res;
    }

    
    public function getMemberCnt($sType, $sText) {
        if($sType != '' && $sText != '') {
            $this->db->like($sType, $sText);
        }
        $this->db->from('member');
    
        return $this->db->count_all_results();
        
    }

    public function getMemberList($sType, $sText, $page) {
        if($sType != '' && $sText != '') {
            $this->db->like($sType, $sText);
        }
        $curLimit = ($page-1) * 10;
        $this->db->select('seq, email, userName, nickName, regDt');
        $this->db->limit(10, $curLimit);
        $this->db->order_by('regDt', 'DESC');
        $res = $this->db->get('member');
        return $res->result();
        
    }

    public function getMemberDetail($seq) {
        $sql = "
            select 
                userName
                , nickname
                , email
                , phone
                , gender
                , lastLoginDt
                , regDt 
            from member
            where
                seq = ?
        ";
        
        $query = $this->db->query($sql, array($seq));
        
        $row = $query->row();
        return $row;
        
        
    }

}