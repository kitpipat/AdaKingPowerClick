<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cLayoutNew extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/layout/mLayout', 'mLayout');
        $this->load->library("session");
    }

    public function FSxCLOT($nLocID) {
        $oHeader = $this->mLayout->FSxMLOTHeader($nLocID);
        $oArea = $this->mLayout->FSxMLOTArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $oLayoutImg = $this->mLayout->FSxMLOTLayoutImg($nLocID);
        $this->load->view('ticket/layout/wLayoutNew', array(
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
            $aImageUplode = array(
					'tModuleName'		=> 'ticket',
					'tImgFolder'        => 'ticketlayout',
					'tImgRefID'         => $nLocID,
					'tImgObj'           => $tImg,
					'tImgTable'         => 'TTKMLocLayout',
					'tTableInsert'      => 'TCNMImgObj', 
					'tImgKey'           => 'main',
					'dDateTimeOn'       => date('Y-m-d H:i:s'),
					'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
            );
            $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
        }
    }

    public function FSxCLOTDelImg() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');
            FSaHDelImgObj($ptImgID, 'TTKMImgObj', $ptNameImg, 'TTKMLocLayout');
            $aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketlayout',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TTKMImgObj',
                'tImgTable'    => 'TTKMLocLayout'
            );
            FSnHDeleteImageFiles($aDeleteImage);
        }
    }

}
