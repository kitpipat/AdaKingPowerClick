<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cLayout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eticket/layout/mLayout', 'mLayout');
        $this->load->library("session");
    }

    public function FSxCLOT($nLocID) {
        $oHeader = $this->mLayout->FSxMLOTHeader($nLocID);
        $oArea = $this->mLayout->FSxMLOTArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $oLayoutImg = $this->mLayout->FSxMLOTLayoutImg($nLocID);
        $this->load->view('eticket/layout/wLayout', array(
            'oLayoutImg' => $oLayoutImg,
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'oAuthen' => $oAuthen,
            'nLocID' => $nLocID
        ));
    }

    public function FSxCLOTAdd($nLocID) {
        if ($this->input->post('ohdLOTImg')) {
            $tImg = $this->input->post('ohdLOTImg');
            FSaHUpdateImg($nLocID, 2, 'TTKMImgObj', 2, 'layout', $tImg, 'location');
        }
    }

    public function FSxCLOTDelImg() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');
            FSaHDelImgObj($ptImgID, 'TTKMImgObj', $ptNameImg);
        }
    }

}
