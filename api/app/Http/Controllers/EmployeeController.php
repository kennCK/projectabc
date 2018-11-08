<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeColumn;
use App\AccountImage;
use App\Template;
use App\CustomObject;
use App\Attribute;
use App\Comment;
use Carbon\Carbon;
class EmployeeController extends APIController
{
    function __construct(){
      $this->model = new Employee();

      $this->notRequired = array(
        'front_template', 'back_template'
      );
    }


    public function create(Request $request){
      $data = $request->all();
      $employee = $data['employee'];
      if($employee != null){
        $this->model = new Employee();
        $employeeInsert = array(
          'front_template'  => $employee['front_template'],
          'back_template'   => $employee['back_template'],
          'account_id'      => $employee['account_id'],
          'status'          => $employee['status']
        );
        $this->insertDB($employeeInsert);
        $employeeId = $this->response['data'];
        if($employeeId > 0){
          $columns = $employee['columns'];
          if($columns != null){
            for ($i = 0; $i < sizeof($columns); $i++) { 
              $colModel = new EmployeeColumn();
              $colModel->employee_id = $employeeId;
              $colModel->type = $columns[$i]['type'];
              $colModel->column = $columns[$i]['column'];
              $colModel->value = $columns[$i]['value'];
              $colModel->created_at = Carbon::now();
              $colModel->save();
            }
          }else{
            return response()->json(
              array(
                'data'  => null,
                'error' => 'Empty',
                'timestamps' => Carbon::now()
              )
            );
          }
          return response()->json(
            array(
              'data'  => true,
              'error' => 'Empty',
              'timestamps' => Carbon::now()
            )
          );
        } 
      }
      return response()->json(
        array(
          'data'  => null,
          'error' => 'Empty',
          'timestamps' => Carbon::now()
        )
      );
    }

    public function updateByProfile(Request $request){
      $data = $request->all();
      $employee = $data['employee'];
      if($employee != null){
        $this->model = new Employee();
        $employeeUpdate = array(
          'id'              => $employee['id'],
          'front_template'  => $employee['front_template'],
          'account_id'      => $employee['account_id'],
          'status'          => $employee['status']
        );
        $this->updateDB($employeeUpdate);
        if($this->response['data'] == true){
          $columns = $employee['columns'];
          if($columns != null){
            for ($i = 0; $i < sizeof($columns); $i++) { 
              if($columns[$i]['new'] == 'false'){
                //update
                $columnUpdate = array(
                  'type'  => $columns[$i]['type'],
                  'column'  => $columns[$i]['column'],
                  'value'  => $columns[$i]['value'],
                  'updated_at'  => Carbon::now()
                );
                EmployeeColumn::where('id', '=', $columns[$i]['id'])->update($columnUpdate);
              }else{
                //create
                $colModel = new EmployeeColumn();
                $colModel->employee_id = $employee['id'];
                $colModel->type = $columns[$i]['type'];
                $colModel->column = $columns[$i]['column'];
                $colModel->value = $columns[$i]['value'];
                $colModel->created_at = Carbon::now();
                $colModel->save();
              }
            }
          }else{
            return response()->json(
              array(
                'data'  => null,
                'error' => 'Empty',
                'timestamps' => Carbon::now()
              )
            );
          }
          return response()->json(
            array(
              'data'  => true,
              'error' => 'Empty',
              'timestamps' => Carbon::now()
            )
          );
        } 
      }
      return response()->json(
        array(
          'data'  => null,
          'error' => 'Empty',
          'timestamps' => Carbon::now()
        )
      );
    }

    public function upload(Request $request){

      $data = $request->all();
      
      $url = null;
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $filename = $data['account_id'].'_'.$date.'_'.$time.'.'.$ext;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        $account = new AccountImage();
        $account->account_id = $data['account_id'];
        $account->url = $url;
        $account->created_at = Carbon::now();
        $account->save();
      }else{
        $url = null;
      }

      return response()->json(array(
        'data'  => $url,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Employee();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        $counter = 0;
        foreach ($result as $key) {
          $id = $result[$i]['id'];
          $this->response['data'][$i]['front_objects'] = $this->getObjectsCustom($result[$i]['front_template'], $id);
          $this->response['data'][$i]['back_objects'] = $this->getObjectsCustom($result[$i]['back_template'], $id);
          $this->response['data'][$i]['front_template_details'] = $this->getTemplateDetails($result[$i]['front_template']);
          $this->response['data'][$i]['back_template_details'] = $this->getTemplateDetails($result[$i]['back_template']);
          $this->response['data'][$i]['total_comments'] = $this->getComments($id);
          $this->response['data'][$i]['active'] = false;
          $this->response['data'][$i]['counter'] = $counter;
          $this->response['data'][$i]['checkout'] = $this->getCheckout('employee', $id);
          $counter++;
          $i++;
          if($counter == 2){
            $counter = 0;
          } 
        }
      }
      return $this->response();
    }

    public function retrieveOnUpdate(Request $request){
       $data = $request->all();
      $this->model = new Employee();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['columns'] = $this->getColumns($result[$i]['id']);
          $i++;
        }
      }
      return $this->response();
    }

    public function getColumns($id){
      $result = EmployeeColumn::where('employee_id', '=', $id)->orderBy('column', 'asc')->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['new'] = false;
          $i++;
        }
      }
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getComments($employeeId){
      $result = Comment::where('payload', '=', 'employees')->where('payload_value', '=', $employeeId)->get();
      return sizeof($result);
    }
}
