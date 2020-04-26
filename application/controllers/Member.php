<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {


	public function index()
	{
		echo "잘못된 접근 입니다.";
    }
    
    /**
     * 로그인 (email,pw)
     */
    public function login() {
        $this->load->model('member_model');
        $email = $this->input->post('email','');
        $passwd = $this->input->post('passwd','');
        
        if($email == '' || $passwd == '') {
            echo $this->resultCodeMSg('-999', '아이디, 패스워드를 입력해 주세요.');
            exit;
        }
        $passwd = hash('sha512', md5($passwd));
        $resLogin = $this->member_model->login($email, $passwd);
        
        if($resLogin) {
            $sess = $this->session->userdata('userSession');
            echo $this->resultCodeMSg('200', $sess);
        } else {
            echo $this->resultCodeMSg('-998', '로그인에 실패하였습니다.');
        }
    }

    /**
     * 로그아웃
     */
    public function logout() {
        $this->session->sess_destroy();
        echo $this->resultCodeMSg('200', '로그아웃 되었습니다.');
    }
    
    /**
     * 회원가입 (이름,별명,비밀번호,전화번호,이메일,성별)
     */
    public function signUp() {
        /**
         * TODO :: refer 체크, validation 체크
         */
        $this->load->library('ghost');
        $this->load->model('member_model');
        
        $userName = $this->input->post('userName','');
        $nickname = $this->input->post('nickname','');
        $passwd = $this->input->post('passwd','');
        $passwdConfirm = $this->input->post('passwdConfirm','');
        $phone = $this->input->post('phone','');
        $email = $this->input->post('email','');
        $gender = $this->input->post('gender','');
        $chkPwdRuleCnt = 0;

        /**
         * TODO :: CI VALIDATION 사용
         */
        
        if($userName == '' || $nickname == '' || $passwd == '' || $passwdConfirm == '' || $phone == '' || $email == '') {
            echo $this->resultCodeMSg('-999', '필수 값을 모두 입력해 주세요.');
            exit;
        }
        if(mb_strlen($userName, 'utf-8') > 20) {    //이름 20자 이하 체크
            echo $this->resultCodeMSg('-998', '이름은 20자 이하로 입력해 주세요.');
            exit;
        }
        if($this->ghost->isKorEng($userName)) {    //이름 한글,영문대소문자 만 가능 체크
            echo $this->resultCodeMSg('-997', '이름은 한글,영문만 입력 가능합니다.');
            exit;
        }
        if(!ctype_lower($nickname)) {   //별명 영문 소문자 체크
            echo $this->resultCodeMSg('-996', '별명은 영문 소문자만 입력 가능합니다.');
            exit;
        }
        if(mb_strlen($nickname) > 30) {   //별명 영문 소문자 체크
            echo $this->resultCodeMSg('-995', '별명은 30자 이하로 입력해 주세요.');
            exit;
        }

        if(mb_strlen($passwd) < 10) {   //비밀번호 길이 체크
            echo $this->resultCodeMSg('-994', '비밀번호는 최소 10자 이상 입력해 주세요.');
            exit;
        }

        if(!$this->ghost->isEngNumSpecial($passwd)) {    //비밀번호 필수값 체크
            echo $this->resultCodeMSg('-993', '비밀번호는 영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함하여 입력해 주세요.');
            exit;
        }

        if($passwd != $passwdConfirm) { //비밀번호 확인값 체크
            echo $this->resultCodeMSg('-992', '비밀번호가 일치하지 않습니다.');
            exit;
        }

        if(!$this->ghost->isNum($phone)) {   //전화번호 숫자만 입력했는지 체크
            echo $this->resultCodeMSg('-991', '전화번호는 숫자만 입력해 주세요.');
            exit;
        }
        
        if(!$this->ghost->isEmail($email)) { //이메일 형식체크
            echo $this->resultCodeMSg('-990', '이메일 형식이 올바르지 않습니다.');
            exit;
        }
        
        if($gender != '' && $gender != "M" && $gender != "W") {
            echo $this->resultCodeMSg('-989', '성별값을 확인해 주세요. (남-M, 여-W)');
            exit;
        }
        
        $passwd = hash('sha512', md5($passwd));
        $data = Array(
            "userName" => $userName
            , "nickname" => $nickname
            , "passwd" => $passwd
            , "phone" => $phone
            , "email" => $email
            , "gender" => $gender
        );

        $msg = $this->member_model->signUp($data);
        echo $this->resultCodeMSg('200', $msg);
    }
    
    public function isLogin() {
        $sess = $this->session->userdata('userSession');
        if($sess) {
            echo $this->resultCodeMSg('200', $sess);
        } else {
            echo $this->resultCodeMSg('-999', 'Not Logon');
        }
    }

    public function getMemberList() {
        $this->load->model('member_model');
        $page = $this->input->get("page");  //현재 페이지
        $sType = $this->input->get("sType");  //현재 페이지
        $sText = $this->input->get("sText");  //현재 페이지
        
        $totalCnt = $this->member_model->getMemberCnt($sType, $sText);
        $data = array();
        if($totalCnt==0) {
            echo $this->resultCodeMSg('200', $data);
            exit;
        }
        if(!$page || $page == '' || $page < 1) {
            $page = 1;
        }
        $totPage = ceil($totalCnt/10);
        $data['data_array'] = $this->member_model->getMemberList($sType, $sText, $page);    //회원 리스트 ()
        $data['nextPage'] = $totPage <= $page ? '' : $page + 1;
        $data['prevPage'] = 1 >= $page ? '' : $page - 1;
        echo $this->resultCodeMSg('200', $data);
    }

    public function getMemberDetail() {
        $this->load->model('member_model');
        $seq = $this->input->get('seq');

        $data = $this->member_model->getMemberDetail($seq);
        if(!$data) {
            echo $this->resultCodeMSg('-999', 'No Data.');
            exit;
        }
        echo $this->resultCodeMSg('200', $data);
    }
    
    public function resultCodeMSg($code, $msg) {
        $res = array(
            "code" => $code
            , "msg" => $msg
        );
        return json_encode($res);
    }

    public function test() {
        $this->load->view('test');
    }


}
