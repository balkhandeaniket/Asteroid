<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asteroid_neo extends CI_Controller {

	public function index()
	{	
		$data = array(
			"message" =>"",
			"date" =>array(),
			"date_count" =>array(),
			"neo_datas" =>"",
			"fastest_distance" =>0,
			"closest_distance" =>0,
			"estimated_diameter_min" =>0,
			"estimated_diameter_max" =>0
		);
		$this->load->view('astroid_neo',$data);
	}

	public function search_action(){
		
		if (!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
			$from_date = date('Y-m-d',strtotime($_POST['from_date']));
			$to_date = date('Y-m-d',strtotime($_POST['to_date']));
			$curl = curl_init();
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$from_date."&end_date=".$to_date."&api_key=9acYXjiL9VQVdindQccj8qdXoKrdDkX00FqWrWWB",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "postman-token: 8fc30e52-eb02-cc4c-9b12-7160b161b0ff"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			$response_decode = json_decode($response); 

			$kilometers_per_hour = [];
			$close_distance = [];
			$estimated_diameter_min = [];
			$estimated_diameter_max = [];
			$date =[];
			$date_count =[];
			$neo_datas = array();

			if (!empty($response_decode->code)) {
				$msg =$response_decode->error_message;
			}else{
				foreach ($response_decode->near_earth_objects as $key=>$row) {
					$date [] = "'".$key."'";
					$date_count [] = count($row);
					foreach ($row as $row_data) {
						array_push($estimated_diameter_min,$row_data->estimated_diameter->kilometers->estimated_diameter_min);
						array_push($estimated_diameter_max,$row_data->estimated_diameter->kilometers->estimated_diameter_max);
						array_push($kilometers_per_hour,$row_data->close_approach_data[0]->relative_velocity->kilometers_per_hour);
						array_push($close_distance,$row_data->close_approach_data[0]->miss_distance->kilometers);
						$neo_data = array(
							"name" => $row_data->name,
							"kilometers_per_hour" => $row_data->close_approach_data[0]->relative_velocity->kilometers_per_hour,
							"close_distance" => $row_data->close_approach_data[0]->miss_distance->kilometers,
						);
						array_push($neo_datas,$neo_data);
					}
					//exit;
				}
				$msg ="success";

				$kilometers_per_hour = max($kilometers_per_hour);
				$close_distance = min($close_distance);
				$estimated_diameter_min = array_sum($estimated_diameter_min)/count($estimated_diameter_min);
				$estimated_diameter_max = array_sum($estimated_diameter_max)/count($estimated_diameter_max);
			}
		
		}else{
			$msg ="Required All Fields";
		}
	
		
		$data = array(
			"message" =>$msg,
			"date" => implode(',', $date),
			"date_count" =>implode(',', $date_count),
			"neo_datas" =>$neo_datas,
			"fastest_distance" =>$kilometers_per_hour,
			"closest_distance" =>$close_distance,
			"estimated_diameter_min" =>$estimated_diameter_min,
			"estimated_diameter_max" =>$estimated_diameter_max,
		);
		
		$this->load->view('astroid_neo',$data);

	}

}
