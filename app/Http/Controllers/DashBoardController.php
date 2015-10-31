<?php

namespace App\Http\Controllers;


use Auth;
use Input;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Users;
use App\Models\Users_site;
use App\Models\Content_category;
use App\Models\Content_type;
use App\Models\Users_site2content;
use App\Models\Subscribers;
use App\Models\Segment;
use App\Models\Subscriber_status;
use App\Models\Mailing_list;
use Cookie;
use Crypt;

function http_post( $url, $data ) {
	
	$eol = "\r\n";
	
	$post = '';

	if (is_array($data)) {
		foreach( $data as $k => $v)
			$post .= $k.'='.urlencode($v).'&';
		$post = substr($post,0,-1);
		$content_type = 'application/x-www-form-urlencoded';
	} else {
		$post = $data;
		if (strpos($post, '<?xml') === 0)
			$content_type = 'text/xml';
		else if (strpos($post, '{') === 0)
			$content_type = 'application/json';
		else
			$content_type = 'text/html';
	}
	if ((($u = parse_url($url)) === false) || !isset($u['host'])) return false;
	
	if (!isset($u['scheme'])) $u['scheme'] = 'http';
			
	$request = $post;
	
	$host = ($u['scheme'] == 'https') ? 'ssl://'.$u['host'] : $u['host'];
	
	if (isset($u['port']))
		$port = $u['port'];
	else
		$port = ($u['scheme'] == 'https') ? 443 : 20222;
	
	$fp = @fsockopen( $host, $port, $errno, $errstr, 10);
	if ($fp) {
		
		$content = '';
		$content_length = false;
		$chunked = false;
		
		fwrite($fp, $request);
		fclose($fp);

		return $content;
		
	} else {
		return false;
	}
}

class CSV {

    private $_csv_file = null;
 
    /**
     * @param string $csv_file  - путь до csv-файла
     */
    public function __construct($csv_file) {
        if (file_exists($csv_file)) { //Если файл существует
            $this->_csv_file = $csv_file; //Записываем путь к файлу в переменную
        }
        else { //Если файл не найден то вызываем исключение
            throw new Exception("Файл ".$csv_file." не найден"); 
        }
    }
 
    public function setCSV(Array $csv) {
        //Открываем csv для до-записи, 
        //если указать w, то  ифнормация которая была в csv будет затерта
        $handle = fopen($this->_csv_file, "a"); 
 
        foreach ($csv as $value) { //Проходим массив
            //Записываем, 3-ий параметр - разделитель поля
            fputcsv($handle, explode(";", $value), ";"); 
        }
        fclose($handle); //Закрываем
    }
 
    /**
     * Метод для чтения из csv-файла. Возвращает массив с данными из csv
     * @return array;
     */
    public function getCSV() {
        $handle = fopen($this->_csv_file, "r"); //Открываем csv для чтения
 
        $array_line_full = array(); //Массив будет хранить данные из csv
        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) { 
            $array_line_full[] = $line; //Записываем строчки в массив
        }
        fclose($handle); //Закрываем файл
        return $array_line_full; //Возвращаем прочтенные данные
    }
 
}


class DashBoardController extends BaseController 
{
	public function get_subscriber(Request $request, $subscribes_id, $segment_id) {
		$user_name = Auth::user();

		$user_site=null;
		$showmodal_change_subscribers=null;
		$subscribes = Subscribers::where('id', '=', $subscribes_id)->where('segment_id', '=', $segment_id)->first();
		$tmp_segment = Segment::where('id', '=', $segment_id)->first();

		if($subscribes) {
			$user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		}
		if($user_site) {
			$showmodal_change_subscribers = true;
		}

		return redirect()->back()->with('showmodal_change_subscribers', $showmodal_change_subscribers)->with('subscribes', $subscribes);
	}

	public function mailingStart(Request $request, $mailing_id){
	$user_name = Auth::user();
	$user_check = null;
	$start = false;
	$message = array(); 

	$mailing_item = Mailing_list::where('id', '=', $mailing_id)->first();
	if($mailing_item) {
		$user_check = Users_site::where('id', '=', $mailing_item->domen_id)->where('user_id', '=',  $user_name['id'])->first();
	}
	if($user_check){
		// формирование сообщения для отправки
		$message['id'] = $mailing_id;
		$message['subscribes']['count'] = '145';
		$message['segment']['Прочее']['email'] = 'name'; 
		$message['segment']['Прочее']['Иванов@'] = 'Иванов'; 
		$message['segment']['Каталог']['email'] = 'name'; 
		$message['segment']['Каталог']['Петров@'] = 'Петров'; 
		$message['schedule']['date'] = '12.12.2015';
		$message['schedule']['time'] = '10:00';
		$message['schedule']['day'] = 'monday'; //или dayly
		$message['schedule']['weekly'] = 'yes';
		$message['from'] = 'test@gmail.com';
		$message['template'] = "<div id=\":10a\" class=\"ii gt m1508779810d70514 adP adO\"><div id=\":146\" class=\"a3s\" style=\"overflow: hidden;\"><u></u><div><center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color:#fbfbfb;float:center;font-family:Open Sans,sans-serif,Arial\" height=\"100%\"><tbody><tr><td colspan=\"6\" width=\"100%\" valign=\"top\" style=\"max-width:620px\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:620px;border:1px solid #dddddd;background-color:#ffffff;margin-top:10px\"><tbody><tr><td valign=\"middle\" style=\"padding:0% 0% 0% 4%;border-bottom:1px solid #dddddd;width:28%;max-width:200px;height:80px\" align=\"left\"><div><a href=\"https://eventing.coursera.org/redirect/BgqxA_7VmQMo0Rt6-0WqBdvizpcgRnvg1T2rRUFJtJt6_oTRdb9aMNAW3Og4s4SoooadbIUS9cl-OvjGe7oHrA.pmCglovPnQSL_otgnyKkbQ._loNal9Qsqekvmx-EuNmTsEg1H5PucPPig9LNSWOgG9cLvDE8GPLP2VAnEWibEEqq931670Li4mRYz4j13cIIsTdjSQw9pdG0WXWsg7Op3sn4wWaSrgeq0xktFshzJmyLCvSp1o69ytjoMWQSgCrm482UGmP3lyDgIXP5afCdRfYlDSmH_VruPty431d-yZwlRy9iR9xJzmKVnCQJM8zX2fCwypUeUuWh8ke8_-g76_PyMxwddJZKFdppd7jDhblMzIAc9HSvp4x2HlxoGadQ5C2QGZEqwQ_HQJrzmyZEW5C7O2i3YsPdT_smhkHeaFtef9jQFv4rKewrZG8hTshonA-nAPH5wCMRP4dPPKLtHjieuz9xGwxCUdGDHtdQGQHnFPTtcdeNsIAXPKaeAcymC_HhzroU3cKWPq2zLkCERnbEVYe50rxvst1NAaBd_H8mk3vmquG5kSDdHf4-cW9B9EzpnyRmYjbLN_Wd17TnctYKVC2ePNPDn9Gtkd3OGXXP5gqAaAyDnU0JEFpe3TH9REmN8bgJR68OWM65Omuin8OmWdFriekgADgcdgwFzW7_AHVBfNCXpPJijrP3CCRuhk64PaJT2Ak62Tp2hqcFKSjfrhSm9N4rBouSGlveWc_\" target=\"_blank\"><img src=\"https://ci6.googleusercontent.com/proxy/sNHUXLbhxxD8aMmfQsi2gkSidA9_f5GOCbRmeNoeIkrXc-gi8l6ixQmOQn-t6Dw5JjWclZgRDon7ZS_5tby1m6ubKuSrutA1D2hhnxtgdgnDmPaG20cHj6E=s0-d-e1-ft#http://coursera-newsletter.s3.amazonaws.com/logo_150_newsletter.png\" alt=\"coursera\" style=\"width:84%;max-width:140px\" class=\"CToWUd\"></a></div></td><td valign=\"middle\" style=\"padding:0% 4% 0% 0%;border-bottom:1px solid #dddddd;width:70%;max-width:420px;font-size:16px!important;height:80px\" align=\"right\"><div><a href=\"https://eventing.coursera.org/redirect/rKwjZ13eNnsUXVkLYleQV1IjXKKXn8I_Q_5YggkkYj8926lmGsp528Cu1Uqx7DQ4UNAk3VAG1mgFFXZIVR3zSw.cH53ROuE_5lAatQSbyzVBA.bqY15xVk4ynmOc7utSGZ3t2yBykWzR-b2swKnnt6u9E2B6147DsRJgmoD_2qGBEY4PbfiSmWdqbM2oRYEPqmq39l5boSkvl70pZpG-XUH13MtD7TMkp-Ww5vkpAU3qbtrweXt5b7aNbylxe-iB_FATDJF-I3ECRXMgtPlXlbhZ68WwM4wf3D-VaSKlbkDABwr8WtVBupWNUw3V4Ktoo9qgGWM_e743cw72cL09CKuGg9AupCNJf2044-cNj0t630cRTSmBIry_kcfcIeZyBA7xPVmXfy2MINVBqrCApBEjgYM0-VaYi_mNkXJqXiomWf2WbIJ_aQP_u3oAZJnaC9APaFRhP4quxmtc2mPOaDkdcYRphtU3Mln4SSx7vRYrua4yoZhLeWtfJoX6Qaps1vrjadV7zwefMPUSdyIzYxgVtQ-oD8kjlB9gXupQ8YF6vn2UnIoRhxJ3aHX-CfQJ2tuQngKWmaS9Kzif6vSxeWjBiJn4qYa0dxCHaaLeDLihbZFkqgOY6YmvD1V5yxDh_kexE3IbtaWWA13W6ogfUkPJy46U3ujT-INtd_GiWZWLGXHlyb6hfnw398TxqX5vzwXCdOKwsznKR9lWAPgRdXTh6yIPSrRn0wtx0ZUn_d8OYT\" style=\"text-decoration:none;color:#787878;border-right:1px gray solid;padding-right:8px\" target=\"_blank\">My Courses</a><a href=\"https://eventing.coursera.org/redirect/XmI70eS2g9LxKZ2A1wMkF1jz3zeR25BkewECpthtKBMZAQFxC7tN9EF7LWvBaZSI0E8IkiNDiRIxUEKchJyfVQ.SSbbeuRmV3b_FmTN-tLisQ.jGCmb1HKKyBwtdhEzcfxoPJ3kO4lBXyQ0UBflIvalRUUFd77K3osFMP7JeQI1MCtegRB5OdwZ7W5jajPyMjfQU1FvglyBd54uLJq0pS_aAUNCa00cbF8Fs7aXqqLYIdNG47n4sqLKhoNIOVp8JtH9gRI1ldtU18ln9Z0ndEOAKOmuOGw8A24ZWbyba-SahhoXRoHha-KuKUFbUHV8psG78GCbO3Cj3NiMi-lxCesi-1xdWMwzNKdYWNPLdjxjzElMU-j7I3GgvdstpuOsnd7OBlRmZxX9eW5g8jv0S23LLDZ3y6ZqJrbG7eYF0ZokLr7hLYhGvbGkRLJHiqyW4Tkwr26NQIPzXN7cvBzFaFc2JMCuox9CT6Lr9hMlfBQq5GbPXLfygV-Q1jwQ5YbLAGc7qcGkfRSFOSYYH_pr8ukC5ULUFRdUu9zIWwGhcMgz-x7GMvI-cNp-uhKyAfEWuFURToy7stWw0YHcSL7uFm54ThmAjJ13dSD6Vjnd1jek5FVRAF4G7UmHK3qJJXfPd6otSKp5aPGZo9epvvhTWAc5lAwNP2AhV3JKwhEF9jxvZoAch_PhJAWPz6zrnyehecxmDRhvwcNIIRt57wgN858ELktUQiOcdzYfEcevyn8Lm3p\" style=\"text-decoration:none;color:#787878;padding-left:8px\" target=\"_blank\">Course Catalog</a></div></td></tr><tr><td colspan=\"6\" valign=\"top\"><table style=\"width:100%;max-width:620px;float:center;font-family:Open Sans,sans-serif\"><tbody><tr><td colspan=\"6\" style=\"text-align:left;height:100%;padding:4% 4% 4% 4%\"><span style=\"line-height:36px;letter-spacing:.6px;color:#b18767;font-size:24px;font-weight:400;padding-bottom:1%;display:block\">Welcome,</span><p style=\"display:block;font-family:'Arial';vertical-align:top\">Thanks for enrolling in Введение в машинное обучение, beginning on January 26, 2016. We're excited you'll be learning with us.</p><p style=\"display:block;font-family:'Arial';vertical-align:top\">We'll send you an email reminder when the course is open for learning.</p><p style=\"display:block;vertical-align:top;margin-bottom:10px\"><a href=\"https://eventing.coursera.org/redirect/tc2k5w0VRZT_xfdBmn394gl4N_ghmMBl_MVSuqD7rd79dBdDEr_qJKO72iV6jcgFJGXg-DcYz86kZXSTEdAMZQ.ex02PUhW8z5o4j1L9LjRuQ.a_DAwKxc9nI_rnMPmnFtpmuWZ6KIR9GcgxP9NtZu_bOvXzBs1urD8Cb2_qHAMO5jYRq0-t_5-zhs7P-CkSL0ea89Y46gy_tLFXduzUCL4LYvKlBshWfZTm_9_qr6xwkZ0vQIHnEb8lSQhDBZxti6TrPtyIEiUq58pggS94XlFY5vmOERpTnFkf28h3r8luWl74Jthuo3LGAv797jeoexBYIKaLmKc3iSD4J35FrkUrA3xu_hUmPc1teUO4-Ttj25UISP3WAQOrUepHDdifsUpmuMTdFdgOGirGXd7RnU705OeI-by-v_s-OV5VNrDdDlWu07ZI4kB3yE8CRnl4DoWyQ6c5oRW8mZoCoFkA8vlPxrjyOmhN5lKIC7HGKYcOe8_-oikGVNNN8jNfxe-nZeWY3UHVfxB5I_8n9-YLRrsIsrWqiUHxfQF1ZoKcumNHDrrHB3A_Nr36edrtXSZO7d7GaRBWcBaRZHLsA5BvI4ttExT1PZvMHl6UG9qpqiqHmnnDXv2kzdPb1fC_iV1foUnYegmgAMmSsfYH9UzYJQ6JJWxNofj-d-loG7P6zLOy8JR47ozpQmMfOMZ11gJbnnlQ\" target=\"_blank\"><img src=\"https://ci5.googleusercontent.com/proxy/OW2tGYHVjFuD2G_od2KNGywRg6FGd6PCHZhvQmhVycSPedN2r1wc64cC1AHOkGOVd3q7B2x_NHfOW8qsu0G6CH03oFDfTTxW-KE5V7UH8KpuJxyR0GEDvG8mBgoS0wnNwavcKwdFZqo_dWTWYuX2hINH8czlRTVvFapGIQ=s0-d-e1-ft#https://coursera-course-photos.s3.amazonaws.com/a2/c23430579811e59644373576122c07/Ya-Icon-new-size.jpg\" alt=\"Введение в машинное обучение\" style=\"width:100%;max-width:600px\" class=\"CToWUd\"></a></p></td></tr><tr><td colspan=\"3\" style=\"padding:0% 0% 4% 4%;float:left\"><a href=\"https://eventing.coursera.org/redirect/M6SHc0bjwtRAPV_uI7WKWLR79PGYsTdMb0l-AwoOcN2U9TfAmQYffy-YdQzupZsWkvS-XP5qm_-A9AI0a-GnHA.CjbumhbB2CU1LNye48DFYw.XBP_5mQhn6RvboBFRUSHL0OF7FHZgir2HIT3IEZz2mH5f4NJCbnh-XjDFs_6f2g0UnL9gMdqvmDyleUK4lM20I-_rN3bM9LV3dtMwfpDsrwdSTq5ofBFHM9QH1TIcrZirZZthP6sQhsbr2LWqCJdge01a7tiZX0helDBU8THBTuwJPrv1GGENvx9RoVEnBKnKAS1TXU9K59s7SO_202UwEE94LbXx2EZWS5NVr6ASMVV2ndGcTq_zLkqxtj7AJAcTdRJ9mG5SfuYajNmOyAq_e-O7MbyUy5l_rmt1h8NnRcn50CGWHf-Xx3jLxmJd092-qBp70QMFEq_Q2K0SNhy0f88kXm6CGlJFrX1kVVSNx6RD2Yq6jRltyd14_frN-hpZ-SU20cXZnev3Fsbt8nQ0UvSUO6uBxgaVkTh_sD9NPw93vIcRrRWZV2uniSOZJmMByQDCIb4p8ROOppZ5dNb-PwWCDcj_e6_uiObMQIlG-0clEV5l_5jE_BUU0UtXKPURX11jk3Bg1-ob0IvDuTDqaS7lCu1VgDF0cPiFQhSUvtkdgguYiK7J7U8fbcbsgFqCC5jwuYtT1rRKbBjjN_fcCO_Xqydo_LGXcWyzqJeZTIePqvh0T8pOVtuiOGPk-C8\" target=\"_blank\"><span style=\"font-size:14px!important;width:40%;min-width:220px;max-width:290px;background-color:#2774d0;line-height:50px;display:inline-block;color:white;border-radius:1px;text-align:center\">Go to Course Dashboard</span></a></td></tr></tbody></table><div style=\"width:100%;max-width:620px;float:center;font-family:Open Sans,sans-serif;border-top:1px solid #efefef\"></div><table style=\"width:100%;max-width:620px;float:center;border-top:1px solid #efefef\"></table></td></tr></tbody></table></td></tr><tr><td colspan=\"6\" width=\"100%\" valign=\"top\" style=\"max-width:620px\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;max-width:620px;float:center;background-color:#ffffff;border:1px solid #efefef;margin-top:32px\"><tbody><tr><td colspan=\"6\" style=\"text-align:left;height:100%;padding:4% 4% 0% 4%\"><span style=\"line-height:36px;letter-spacing:.6px;color:#444444;font-size:24px;font-weight:400;padding-bottom:1%;display:block\">Download the Apps</span><p style=\"width:100%;display:inline-block\"><a href=\"https://eventing.coursera.org/redirect/pvtJex31JnTRJo4poO9TfT2fS5qhr7mJFRGi8uAlWl578B9RFl4kkg5nz1xwJn2N_U_gHeytbvguZ44KRXbqLw._nA0J3nkoG9dr13Pm_wYRw.PQ8mV-NzXCfCeKmyN-WdIdYlOH4Q84QwgczBQLI9r0cFOb_3MfDQqxJztzHXbajtPrJITXZHJCyGNmiXxxTKcwv8UA80_CXDlUuUWHx7g5ZTE6gV0ejVvn6Jl67JQP_xXKVUz-E-kjW8UzvihStVcaujvhmYFmZxVzpronl2HfmHO05vz-vw-nZq76is5lzxpfLY0N2rGf_ReItnNGymd2ZCe82Anb_UIWNisYl5ohXRwPhFAo7hdJoLA2Ac8GxE_xhLhFrARl8pXExLL6_PeScszLIWkwxLo3WfFVtfo41JzIIjXBvsfx-2yag2PgZm-Q0KWBYG8gb_622shK7uS8kIa8ZZ7mAxafxQHPtistI0XfqxZgC7WlmIzrl29nBfNE8iCwvnYo86648Vw8-MplPhhpo3H6US7iAAyZfPLbDs4PTdn2o7yMRjDOdytGxlX_lXtvd0FNIInvFEA8Vm8thaTIoUEUCEqy7M4fOdHF0QW2EQzYUe53ChnGUc9auGYagL5frV9u5ckGKR83XPyTf4FCqD5sbSTMEX34eIoVRT-bmX_IlN0dxqnnavjpiQHEoJipKsoOHP9R8JzURQe5ts4qqtMzc2njXvFH5lLJqgWIRq305qH671wtArc4n1kISyel-jZWaNIuzh4vWmih0tqB4Shd-TUBMOu34zXmk\" target=\"_blank\"><img src=\"https://ci6.googleusercontent.com/proxy/miSiVt5Mjn2v2peHN4L5nDGdPrQtS5eUTCKxGGFe3144GwFllajTsga1BsTmPrjur6uoKoXXc1ww4chiSANiSnNV6dpBmNgloTaEF2Du-FCQfvCBXEwKW_p83BoxpeNrUAyOejvnN3cNSPVi=s0-d-e1-ft#https://d2wvvaown1ul17.cloudfront.net/site-static/images/icons/download_from_apple.png\" alt=\"coursera app for iphone\" style=\"width:39.5%;float:left;border:none;max-width:100px\" class=\"CToWUd\"></a><a href=\"https://eventing.coursera.org/redirect/ECn9eOFw2KL8CNJRORWtnX4nYSYBNxBhXoO8C65_2j44ItREtpx06LC5v60Vnff1KVvQyPGbmKWYUgKzZAnmaQ.zlJUALnuW95R2amTbq_H1A.yx3581AMZvAS6woVq1NYaoY4VeyOGpZluaLUacqdabiOW1eXF677XOPX3ueW72iUCOp5YINSdl9SlJiHCwTQ6fQpcGXXbKKHZQHA-rQAQo_dtV-q2lKi2gj4lxtniQFuCtV8dEOLLhpPjZbVxWmYklQcNrvgg0LcpFeO5HUwKPColhBpODQM3oPs-mWN_Js1dCN_Mu8KaXQ_4KmfZXVB1kMof1C-1RmU5xyWwulIKixZG_LhwBCCF4sewvZby-c3wMYeXko25LW5od3cn1NClwK--Ffl6EbvYXlHK2dBb5Pa5P94BHQEbDR2VhaWAwkdxfgcsBhMbNcFlJ6b9qezZWITC03hS3zoh71uUT-uPf4yqPuMDb7gCb2Aw1DFV59o_RTtP3F2IGp4azbIhn6pO8b7mn2tIyEfK_4fd6Zrf0nWXlUeGKl5K6hk_xEdeqJR7dlRZAFGwRWnT_ie6RfKEJihjfahVu8RyF4Wxr4kBS7tQ6MSgYIBY9G6G3QscQRuLl2B6we5vJhMmvHdDwBf1xtziJoc8kEm9-CBieJjF6OCIBe-llzgk9n-KdsDPyuJvhMixhkXof6Jpc1TuOsK9BRvR-QzwLMn8vqiGafBj0p6s7mG2ZZ2fZfv4p0yZ6Slksbgh0u9Ainu2kjgLWrgmTBr8Pj-iuuQH0dd-QYmustmapTZjYFk-4uA8a-pkD3K\" target=\"_blank\"><img src=\"https://ci5.googleusercontent.com/proxy/m81aWc4qZls3v4cuzcHTwsYn7BstwbdUwguiZlpcJVHQTq7_b4ttIHdOsMR_ok_7L3fFb8WrSQqt52A4fcYF2XnvPySQ864_vLI21NwcR34Bfq2HZhLmR0SX_ST_=s0-d-e1-ft#https://coursera_assets.s3.amazonaws.com/about/mobile/badge_android.png\" alt=\"coursera for android\" style=\"width:37%;float:left;border:none;max-width:90px;padding-left:4%\" class=\"CToWUd\"></a></p></td></tr><tr><td valign=\"top\" style=\"padding:0% 0% 6% 4%;float:left;font-size:14px;line-height:1.4em;color:#787878;text-align:left\"><a href=\"https://eventing.coursera.org/redirect/AsVNSwZIpImt4mAxhmjtw4JhvzMyCde1VHDkB7HkUZY7I-mszS6L60Jxdb6rftx7GrKvlPlHTJtoxt01aFaSfQ.zW-tLYMajvAkfqusO5iccQ.HG9k7Sj3v4xTeVlNBRja3h6O8mF55Am3M9ENCsPQN4sDyAwqSiiIFF9lQ-b8eUCIOxubI1U_MT12QtvEe6b_cD0giO7DZ0qI5Wrgw2a0z6Hmkhh4DHsRnUrFJIz475HXdu_jQAE92HYnf7JPnK76eEHDnwlV_q9U9N7Clt8fvY0qdA7FD_8NDLvPn5h2eRHhpvU1cb93yzoZQQlhsYYBTgktIOID9P4Dcjaxktbebl8KiSXxYxxnjzhLGy0sO3ldwyqQzEvPUCcrMTh3N7TesWZB6pmHpWxL7VVRBDjSlOd5_gwTLOZ82vv8heW8XfAbIc4cSOYj3NeKBIluHTUw4pjGJvPeU7Tjsk_PnRBawS-PFtqXeQJN0u__uZ0SyUwjSIoGAMboG-Czbuj91MuIwbnFnOGAYOUNo3DFlxiU2469aQa0ticBeivOV0J-iB0PKIEFZ7Qs71KigSBqxYF9KSxhe2AEXlF-zzNq_ZcmAmbQUcvBwDR78-B74dMu7T9OKnzDX97G_-jfHPRMpbKB0RrWwSbf38tdBnaYl32w8cmgtfu4JmIiK5yVlr1AcoTBR3HmmzCMPQ1QUi4t9tKLZ8M5L6ynR8S-rE7Vw8U85FdW_oR6eWcNKis1JjgdEw4y\" style=\"color:#4278d3;text-decoration:none;font-size:14px\" target=\"_blank\">Learner Help Center</a>  |  Please do not reply directly to this email</td></tr><tr><td colspan=\"6\" valign=\"top\" style=\"padding:4% 4% 4% 4%;background-color:#eeeeee;font-size:14px;color:#444444;text-align:left\">Coursera sends these notifications to improve your learning experience.&nbsp;<a href=\"https://eventing.coursera.org/redirect/pNkN2LbDqL2Bz63hK0CBhRHEMzRtFhCGzvZFaJjullbiXGjorDiux2eXW6fd21X4xCSvYkxGA5CPmJOmz58M_A.nUKOvKr4FkmunVrPun-fIg.U_nIa8-09a6x2Z6pFTS97AwCvR2F1I3oIAWC3owaiw7Oyv-MKElnRcxMaaivZwQ3pUOrEsVAwjC3RPLIf3tUj3ND_pI-UHDFHUcp0-HD_wohZKQeXUHhj6M3cJ1QVqfAqa0hdvN-sWha4Mncrzl-IRh4pVOklNP9TGnJ76bjFLU_jSJTE48KRj38w8fKynQduMVA6xNrvGcFNf_cmRj04Z6Xd-GB5xO8lifmUPK6-ad6oHh0xtqtZC99Gu5ykmv-EkIuuBBJY3FRhG5dsK59CQrTOz2YRa0UAvd3USnJFI-YuW-FxhpFE2IcedGdDBfzh97R6vrRSG_ypKbk2xZ4D6WaQ4CDxZVkEV9frfxLDikSPMJ-XAijsy8-JKHDn8R8o5EDyhdg9UPpoeWoBwv6Jf93K7Di7o3F49K5GblZNEYyzpW5dXuALxChV1LepUyL5dp1qJJPfWRk9EirPQKvqMla7cLejzg6ohm_0wPA2Bl19NgW2SYBsSswVEuzques245-QN-u3r2JIffrNu2u47_i8RyLuRxXpBxd8SfShns-srz28WxQDAL-aTBO-9nRwt7N9Zc2GWF0O0k84N91-YMX6LI_Qu7n2UabBvYjdSOSXeVhr1K_5vvHKUjo0CHlLmz4SYui1OdAM_ibMLQ1MINRhRDzACYw8KYsB5TjEx4veR3VCssn_M64dpbDrbMZ1IRH3J7nReY6Q6V0OeG473bzIBJdbrERk6xbYrRKW4Cbbboe6xNarDBeUgUkbWjt7rOlFIihnuzxuJywrffLOAPym6YGNsj5-5NGtHRGlBWop9UUoGiQoogevF0x\" rel=\"nofollow\" style=\"color:#3e3e3e;text-decoration:underline\" target=\"_blank\">Unsubscribe</a></td></tr><tr><td colspan=\"6\" valign=\"top\" style=\"padding:4% 4% 4% 4%;background-color:#2d2d3b;font-size:12px;color:#d3d3d5;text-align:left\">© 2015 Coursera<br>381 E. Evelyn Ave.<br>Mountain View, CA 94041 USA</td></tr></tbody></table></td></tr></tbody></table></center><img src=\"https://ci4.googleusercontent.com/proxy/BJMXSJXKTJmTuvCVhuhai7Sh7KdpFlJtSK5-7QTV6bjrHCYCbykEdjuiB6FW-EYE-4I-igtySsW5TiRV_xUnDU_gSBT3gU0uiQBcBMNKxjt1Qbj7vW1s1Q8xhOetDbgMH02O507P-sDc6ttMXcVVfwF0_ffAv4TK3GBOssvQ3YGsshw7VE3uj02rWNFfX8k87uveXUVy9JCpzMzO7lF-cuwZuDgZyT08KN07tDFHTxmezpMAS7-Rpqg_iSKPfdQRA1hizQILUUMIEjO2Jai5q4wMHk-MLTtptNRDscKgL4OXNWo-y6gOanXOcTnZhub_Nsk0dy0hMyGWafR_V8fw0sEz4Yi1xZdaA5b_DduUbZivdG155mnuvd5GLM-2ZacdXoDhSYoyjmz7uNN01KUmwdXi_ZogKC5fSniQacRV_4tshqRvXV_qhomC34aZL0C6aEFM_XL6lPSCVT9BbFusbF2Gt9k7uxbX0V8bbCvXos6QpjjBQIrNu9yQYJx_Q-BRS2GQmYjUT2wGphvwjfOtpUyHJV08hEeBkO-N3vYLRgmkBtXxhdY8KyHkB6VRvrLptlGPsCj5SpPrwox_mRTh-bIJsEmwmG7AamLGYX9jl2rG0ERIKXIGw9WxILHVhKwAHnmFj6zJmHKuEJNiLkH1NufqAU_ipYbytJ-AIJUIeTbVb7glQ4xRg9gR5VFLlTn3uOWgc8Mri_h606c0RGR_8fHEq5k14044QOa4qsZWtGZIsXFNRDRvH1lhP5hU=s0-d-e1-ft#https://eventing.coursera.org/img/W-hj4Db_tnmFp2zyLoqHZX00nycop05ZCwUphWxS5i0B4XbbTBRPdXZAGgRqdeyUuEAr5Qt0omMEq3eD6kiH1Q.WriUmoAnbZw94ejXCOJDFw.ck5VRW46A_S2sE2b1l-xy0pq85-8NWAkLfmo7itT9A_u2hcJ64cTvv_tPzbHQ6e-RGtfn9VMGz1-MP5tKe7P3UJMZwJuCkvO4VZ397mDMT6daCsNphv7iPG0FZ_7ZUm5yHt2SnUoyoVSDQV30grP-2nwhwtPQYcpDNQ_88-cOjyxN4LsPEQeRKXMbXXzD6W6uaz3i4cAeb2i3qcqraLanHkqCfehX7yyZiCgKNJ2J-2r30BkGTElKdtZOi8PQ0qTgOAej6ec25SvNLDHkYhpDJzJy4BCsL2b7_WQvOMUnepInfFlyijtR26LZRWLcKC8T1D5EcpsoAz0vM4VbIv3Arrr9YP_VQMr5AxP-wWiuXjTaJUkI_FBI6D3wrN84BOk6OYNNSoT1dX5sn1umI9yCA\" border=\"0\" width=\"1\" height=\"1\" class=\"CToWUd\"></div></div><div class=\"yj6qo\"></div></div>";
		$start = true;
	}
	


	if($start) {	
		dd('рассылка запущена');
		$json = json_encode($message);
		$result = http_post('http://78.47.250.95', $json);
		//отправка без обратного сообщения, что всё ок. 
		//статистика будет писаться в логи
	}
		
		return redirect()->back();
	}


	public function addDelivery(Request $request){
		/*=============================================================*/
		$user_name = Auth::user();
		$domen_id = null;
		$current_domen_cookie = $request->cookie('current_domen');

		if(isset($current_domen_cookie)) {
			foreach ($current_domen_cookie as $current_site) {
				$domen_id = $current_site->id;
			}
		}
		else {
			$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
			$domen_id = $default_domen->id;
		}


		$current_domen = Users_site::where('id', '=', $domen_id)->get();

		$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

		$domen_clear_list = null;
		$ready_site_name = null;
		if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
			foreach ($current_domen as $current_site_name) {
				$ready_site_name = $current_site_name->domen;
			}
			foreach ($domen_list as $site_name) {
				if($ready_site_name != $site_name->domen)
					$domen_clear_list[$site_name->id] = $site_name->domen;

			}
		}
		/*=============================================================*/

		$templates_array = ['Шаблон 1', 'Шаблон 2'];
		$auditors_array = ['Аудитория 1', 'Аудитория 2', 'Аудитория 2', 'Аудитория 3'];
		$delivery_periods = ['Период 1', 'Период 2', 'Период 2', 'Период 3'];
		$delivery_times = [];

		for($hour = 0; $hour <= 23; $hour++){
			$str_hour = strlen($hour) < 2? "0".$hour:$hour;
			$delivery_times[] = $str_hour.":00";
		}

		$d = [];

		return view('delivery.add', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'user_name' => isset($user_name) ? $user_name:null,
			'templates_array' => $templates_array,
			'auditors_array' => $auditors_array,
			'delivery_periods' => $delivery_periods,
			'delivery_times' => $delivery_times
		));
	}

	public function change_subscriber(Request $request, $subscribes_id, $segment_id) {
		$user_name = Auth::user();
		$user_site=null;		

		$subscribes = Subscribers::where('id', '=', $subscribes_id)->where('segment_id', '=', $segment_id)->first();
		$tmp_segment = Segment::where('id', '=', $segment_id)->first();

		if($subscribes) {
			$user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		}
		if($user_site) {
				if(($subscribes['email'])==$request['email'] && $request['email']) {
					 $subscribes->name = $request['name'];
					 $subscribes->surname = $request['surname'];
					 $subscribes->sex = $request['sex'];
					 $subscribes->age = $request['age'];
					 $subscribes->city = $request['city'];
					 $subscribes->save();
				}
				else {
					$validator = Validator::make(
					    array(
					        'email' => $request['email']
					    ),
					    array(
					        'email' => 'required|email'
					    ),
					    array(
						    'required' => 'Вы не заполнили поле :attribute',
							'email' => 'Email быть корректным'
						)
					);

					$subscriber_email = Subscribers::where('email', '=', $request['email'])->where('segment_id', '=', $segment_id)->first();

					if ($validator->fails() || $subscriber_email) {

						$errorMessage = $validator -> messages();
						$errors = "";
						foreach ($errorMessage-> all() as $messages) {
							$errors .= $messages . " ";
						}
						if($subscriber_email) $errors .= "Такой email уже используется в этом сегменте" . " ";
						return redirect()->back()->with('showmodal_change_subscribers', true)->with('subscribes', $subscribes)->with('errors', $errors);
					}
					else {
						$subscribes->name = $request['name'];
						$subscribes->surname = $request['surname'];
						$subscribes->sex = $request['sex'];
						$subscribes->age = $request['age'];
						$subscribes->city = $request['city'];
						$subscribes->email = $request['email'];
						$subscribes->save();
					}
				}
		}
		return redirect()->back();
	}
	

	public function delete_subscriber(Request $request, $subscribes_id, $segment_id) {
		$user_name = Auth::user();

		$user_site=null;		

		$subscribes = Subscribers::where('id', '=', $subscribes_id)->where('segment_id', '=', $segment_id)->first();
		$tmp_segment = Segment::where('id', '=', $segment_id)->first();

		if($subscribes) {
			$user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		}
		if($user_site) {
			$subscribes->delete();
		}
		return redirect()->back();
	}

	public function subscribers_change_status(Request $request, $id) {
		$subscribers_change_status = $id;
		if($subscribers_change_status == 1000) {
			$subscribers_change_status = null;
			return redirect('/dashboard/audience/')->withCookie('subscribers_change_status', $subscribers_change_status); 
		}
		else return redirect('/dashboard/audience/')->withCookie('subscribers_change_status', $subscribers_change_status); 
		
	}

	public function paginate_filter_audience(Request $request, $id) {
		$pagination_store = $id;
		return redirect('/dashboard/audience/')->withCookie('pagination_store', $pagination_store); 
	}
	

	public function download_segment(Request $request, $id) {

		$user_name = Auth::user();
		$tmp_domen = Segment::where('id', '=', $id)->first();
		$tmp_user = Users_site::where('id', '=', $tmp_domen['domen_id'])->first();

		if($tmp_user['user_id'] == $user_name['id']) {
			$subscribes_all = Subscribers::where('segment_id', '=', $id)->get();
			$list = array();
			foreach ($subscribes_all as $value) {
				array_push($list, array(
					$value->email,
					$value->name,
					$value->surname,
					$value->sex,
					$value->age,
					$value->city,
					Subscriber_status::where('id', '=', $value['status_id'])->first()['status_name']
					));
			}

        // $content = iconv('UTF-8', 'WINDOWS-1251', $content);

		$content = implode("\r\n", array_map(function($x){
		  return '"'.implode('";"', $x).'"';
		}, $list));

        return (new Response($content, 200)) //формирование файла на лету
            //->header('Content-Type', 'text/csv')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'application/octet-stream')
            ->header('Accept-Ranges', 'bytes')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate')
            ->header('Pragma', 'public')
            ->header('Content-Length', strlen($content))
            ->header('Content-disposition', 'attachment;filename=segment_'.$tmp_domen['id'].'_'.date('Y-m-d').'.csv');
    
		}

		else return redirect()->back();
		
	}


	public function add_audience_file(Request $request) {
			
			$user_name = Auth::user();
			$domen_id = null;
			$current_domen_cookie = $request->cookie('current_domen');

			if(isset($current_domen_cookie)) {	
				foreach ($current_domen_cookie as $current_site) {
					$domen_id = $current_site->id;
				}
			}
			else {
				$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
				if(isset($default_domen)) $domen_id = $default_domen->id;
			}


			$new_file_tmp = $request->files; //получаем прикрепленный файл из запроса
			$new_file;
			foreach ($new_file_tmp as $key => $value) {
				$new_file = $value;
			}
			if(isset($new_file)) {
				if(pathinfo($new_file->getClientOriginalName())['extension']=='csv') { //проверка если это csv или это txt			

					try {
						$error_message_save = null; //сообщение об ошибке
					    $csv = new CSV($new_file); //Открываем наш csv
					    /**
					     * Чтение из CSV  (и вывод на экран в красивом виде)
					     */
					    $get_csv = $csv->getCSV();

					    $exists_segment = Segment::where('domen_id', '=', $domen_id)->where('segment_name', 'LIKE', $request->name)->first();

					    if(!$exists_segment['segment_name']) { //проверка на существование сегмента для этого сайта
						    $segment = new Segment;
						    $segment->segment_name = $request->name;
						    $segment->domen_id = $domen_id;
						    $segment->save();
						}

						$segment_id = Segment::where('domen_id', '=', $domen_id)->where('segment_name', 'LIKE', $request->name)->first()->id;
						
						// else if(){}
					    $count_str = 1; //добавить проверку на емаил если уже есть такой то пропустить строку, для этого надо сделать запрос и добавить сегмент
					    foreach ($get_csv as $value) { //Проходим по строкам и загружаем в модель, подсчитваем брак и пишем в лог
						        // dd($value);
						        if(count($value)==6) {

						        	$exists_email = Subscribers::where('segment_id', '=', $segment_id)->where('email', '=', $value[0])->first();
						        	if(!$exists_email) {//существует ли в сегменте такой e-mail и есть ли у подписчика email, если да то пропускаем и к следующему элементу
							        $subscriber = new Subscribers;
							        $subscriber->email = $value[0]; //email
						      		$subscriber->name = $value[1]; //имя
							        $subscriber->surname = $value[2]; //фамилия
							        $subscriber->sex = $value[3]; //пол
							    	$subscriber->age = $value[4]; //возраст
							    	$subscriber->city = $value[5]; //город
							    	$subscriber->status_id = 1; // статус 1 - Исходный пользователь
							    	$subscriber->segment_id = $segment_id;
							    	$subscriber->save();
							    	$count_str++; 
							    	}
							    	else {
							    		continue; 
							    	}
				    			}
						    	else {
						    		return redirect()->back()->with('error_message_save', 'Операция завершена с ошибками на '.$count_str.' строке. Столбцов должно быть 6');
						    	}
					    }
					    
					}

					
					catch (Exception $e) { //Если csv файл не существует, выводим сообщение
					    echo "Ошибка: " . $e->getMessage();
					}
				}


			else if(pathinfo($new_file->getClientOriginalName())['extension']=='txt')
			{
				
			}
		}
		//и редирект на главную = аудиторию
		/*=============================================================*/
				
				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }

		        // $segment = Segment::where('domen_id', '=', $domen_id)->get();
				/*=============================================================*/

		return view('dashboard', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null,
			'errors_after_load' => isset($error_message_save) ? $error_message_save:null //ошибки при загрузке файла
			// 'segment' => isset($segment) ? $segment:null
			));
	}

	public function mailru() { //для подтверждения
		return view('mailru-domain');
	}

	public function change_domen(Request $request, $id) {
		$user_name = Auth::user();
		$current_domen = Users_site::where('id', '=', $id)->where('user_id', '=',  $user_name['id'])->get();
		$current_segment = Segment::where('id', '=', $id)->first();


		return redirect()->back()->withCookie('current_domen', $current_domen)->withCookie('current_segment', $current_segment); //меняем домен по выбору пользователя
	}
	
	public function change_segment(Request $request, $id) { //меняем сегмент
		$user_name = Auth::user();
		$tmp_segment = Segment::where('id', '=', $id)->first();
		if(isset($tmp_segment)) $tmp_user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		$current_segment = null;

		if(isset($tmp_user_site)) {
			$current_segment = $tmp_segment['id'];
		}

		return redirect()->back()->withCookie('current_segment', $current_segment); //меняем домен по выбору пользователя
	}

	public function delete_segment(Request $request, $id) { //удаляем подписчиков и сегмент
		
		$user_name = Auth::user();
		$tmp_segment = Segment::where('id', '=', $id)->first();
		if(isset($tmp_segment)) $tmp_user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		$current_segment;
		
		if(isset($tmp_user_site)) {
			$delete_subscribers = Subscribers::where('segment_id', '=', $id)->get();
			foreach ($delete_subscribers as $value) {
				$value->delete();
			}

			$tmp_segment->delete();
		}

		return redirect()->back(); //меняем домен по выбору пользователя
	}

	public function find_subscribers(Request $request, $id) { //ищем подписчиков

		$user_name = Auth::user();
		$subscribers_find;
		$no_subscribers = null;
		$tmp_segment = Segment::where('id', '=', $id)->first();
		if(isset($tmp_segment) && $tmp_segment!=null) {
			$tmp_user_site = Users_site::where('id', '=', $tmp_segment['domen_id'])->where('user_id', '=',  $user_name['id'])->get();
		}
		   else $no_subscribers = "Подпичик не найден";
		if(isset($tmp_user_site) && $tmp_user_site!=null) {
				$subscribers_find = Subscribers::where('email', '=', $request->search)->where('segment_id', '=', $id)->first();
		}
		else $no_subscribers = "Подпичик не найден";
		if(!isset($subscribers_find)) $no_subscribers = "Подпичик не найден";

		return redirect()->back()->with('subscribers_find', $subscribers_find)->with('not_found', $no_subscribers);
	}

	public function dashboard(Request $request) { //отображение ЛК и передача на ЛК необходимых массивов
				/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					if(isset($default_domen)) $domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
		        // $segment = Segment::where('domen_id', '=', $domen_id)->get();
				/*=============================================================*/
				
		return view('dashboard', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null
			// 'segment' => isset($segment) ? $segment:null
			));
	}

	public function widget(Request $request) { //отображение ЛК и передача на ЛК необходимых массивов
				/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
				/*=============================================================*/

		return view('dashboard.widget_page', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null
			));
	}

	public function add_audience(Request $request) { //отображение формы добавления базы в ЛК
		
		/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
				/*=============================================================*/
		return view('add_audience', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null
			));
	}

	public function add_audience_segment(Request $request, $id) {
		/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');


				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				$current_segment_to_add = Segment::where('id', '=', $id)->where('domen_id', '=', $domen_id)->first();
				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
				/*=============================================================*/
		return view('add_audience', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null,
			'current_segment_to_add' => isset($current_segment_to_add) ? $current_segment_to_add:null
			));
	}

	public function add_next_site(Request $request) {
		/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
		        // $segment = Segment::where('domen_id', '=', $domen_id)->get();
			/*=============================================================*/


		$second_site_code = 'YES';

		return view('dashboard' , array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null,
			'second_site_code' => isset($second_site_code) ? $second_site_code:null
			// 'segment' => isset($segment) ? $segment:null
			)); 
	}

	public function mailing(Request $request){
		/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
		/*=============================================================*/
		// $test = Mailing_list::first();
		// dd($test->period);
        return view('dashboard.mailing_page', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null
			));
	}

	public function templates (Request $request){
		/*=============================================================*/
				$user_name = Auth::user();
				$domen_id = null;
				$current_domen_cookie = $request->cookie('current_domen');

				if(isset($current_domen_cookie)) {	
					foreach ($current_domen_cookie as $current_site) {
						$domen_id = $current_site->id;
					}
				}
				else {
					$default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
					$domen_id = $default_domen->id;
				}

				
				$content_category = Content_category::all();
				$content_type = Content_type::all();
				
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

				$domen_clear_list = null;
				$ready_site_name = null;
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }
		/*=============================================================*/

        return view('dashboard.templates_page', array(
			'current_domen' => isset($current_domen) ? $current_domen:null,
			'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
			'content_category' => isset($content_category) ? $content_category:null,
			'content_type' => isset($content_type) ? $content_type:null,
			'user_name' => isset($user_name) ? $user_name:null
			));

	}

	public function	add_site(Request $request){ //добавлен реквест, форма добавления сайта
		$addsite_input = Input::all();
		
		$user_name = Auth::user();
		$user_site = new Users_site;

		$user_site->domen = $addsite_input['domen'];
		$user_site->user_id = $user_name['id'];
		$user_site->visitor = $addsite_input['visitor'];
		$user_site->base_size = $addsite_input['base'];


		$validators = Validator::make(
				[
					'Domen' => $addsite_input['domen'],
					'Посещаемость' => $addsite_input['visitor'],
					'Размер базы' => $addsite_input['base'],
					'Тип контента' => $addsite_input['content_type'],
					'Категория контента' => $addsite_input['content_category'],
				],
				[
					'Domen' => 'required|max:28|unique:users_site',
					'Посещаемость' => 'required|numeric',
					'Размер базы' => 'required|numeric',
					'Тип контента' => 'required|max:28',
					'Категория контента' => 'required|max:28',

				],
				[
					'required' => 'Вы не заполнили поле :attribute',
					'email' => 'Email быть корректным',
					'unique' => 'Такой :attribute уже используется',
					'min' => 'Поле :attribute должно содержать минимум :min символов',
					'max' => 'Поле :attribute должно содержать максимум :max символов',
					'numeric' => 'Поле :attribute должно содержать только цифры',
				] 
			);


			// Корректность ссылки (URL)
			function check_url($url)
			{
			  
				if (!strstr($url,"://"))
				  {
				    $url="http://".$url;
				  }
			 	if (preg_match('~^(http|https)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?~i', $url)) {
		   		  return $url;
			  	}
			  return false;
			}
			 // Существование ссылки (URL)
			function open_url($url)
			{
			 $url_c=parse_url($url);
			 
			  if (!empty($url_c['host']) and checkdnsrr($url_c['host']))
			  {
			    // Ответ сервера
			    if ($otvet=@get_headers($url)){
			      return substr($otvet[0], 9, 3);
			    }
			  }
			  return false;     
			}
			$domen_check = "";
			// Проверка ссылки
			$url = $addsite_input['domen'];
			
			if ($url=check_url($url))
			{
			  // ссылка корректная
			  if ($o=open_url($url))
			  {
			    $domen_check = 'ok';
			  }
			  else
			  {
			    $domen_check = 'no'; //сервер не отвечает
			  }
			}
			else $domen_check = 'no'; //некорретрная ссылка

			if($validators->fails() || $domen_check == 'no' || $addsite_input['visitor'] < 0 || $addsite_input['base'] < 0) {
				$errorMessage = $validators -> messages();
				$errors = "";
				foreach ($errorMessage-> all() as $messages) {
					$errors .= $messages . " ";
				}
				if($domen_check == 'no') $errors .= "Такого домена не существует" . " ";
				if($addsite_input['visitor'] < 0) $errors .= "Поле посещаемость должно быть ноль или больше" . " ";
				if($addsite_input['base'] < 0) $errors .= "Поле размер базы должно быть ноль или больше" . " ";

				return \Redirect::back()->with('add_site_errors', $errors);
			}
			else {
				$user_site->save(); //сохраняем сайт

				$domen_id_arr = Users_site::where('domen', 'like', $addsite_input['domen'])->get();
				foreach ($domen_id_arr as $domen_value) {
					$domen_id = $domen_value->id;
				} 


				foreach ($addsite_input['content_type'] as $value_type) {
					$users_site2content = new Users_site2content;
					$users_site2content->domen_id = $domen_id;
					$users_site2content->type_id = $value_type;
					$users_site2content->save(); //сохраняем тип контента
				}

				foreach ($addsite_input['content_category'] as $value_category) {
					$users_site2content = new Users_site2content;
					$users_site2content->domen_id = $domen_id;
					$users_site2content->category_id = $value_type;
					$users_site2content->save(); //сохраняем категорию контента
				}

				$user_name = Auth::user();
				$current_domen = Users_site::where('id', '=', $domen_id)->get();
				$domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();
				if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
					$domen_clear_list = null;
					foreach ($current_domen as $current_site_name) {
						$ready_site_name = $current_site_name->domen;
					}
		            foreach ($domen_list as $site_name) {
		            	if($ready_site_name != $site_name->domen)                  
		                $domen_clear_list[$site_name->id] = $site_name->domen;

		            }  
		        }

				return redirect('dashboard/add_audience')->withCookie('current_domen', $current_domen)->withCookie('user_name', $user_name)->withCookie('domen_clear_list', $domen_clear_list);
			}

	}
}
