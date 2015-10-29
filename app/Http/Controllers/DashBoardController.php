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
		else $no_subscribers = "Подписчик не найден";
		if(!isset($subscribers_find)) $no_subscribers = "Подписчик не найден";

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
