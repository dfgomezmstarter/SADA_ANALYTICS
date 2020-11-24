<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VandermondeController extends Controller
{
    public function vandermonde(){
        $data = [];
        $mem = session()->get("mem");
        $data["mem"] = $mem;
        $data["checkMem"] = "true";
        $data["storage"] = "false";

        $data["solution"] = "false";
        $data["title"] = __('vandermonde_method.title');
        $data["message"] = __('vandermonde_method.title_method');
        return view('vandermondeMethod')->with("data",$data);
    }

    public function vandermondeMethod(Request $request){
        $Arrx = []; 
        $dimension = $request->input("n");
        $save = $request->input("save");
        $Arry = [];

        for ($i=0; $i < $dimension; $i++) { 
            array_push($Arrx, $request->input("x".$i));
            array_push($Arry, $request->input("y".$i));
        }

        $mem = session()->get("mem");
        $indexMem = $mem[2][0];
        $mem[2][0] = $mem[2][0]+1;
        if ($mem[2][0]>2) {
            $mem[2][0] = 1;
        }
        $auxMem = [];
        if ($save == "save"){
            array_push($auxMem,$Arrx);
            array_push($auxMem,$Arry);
            array_push($auxMem,$dimension);
            $mem[2][$indexMem] = $auxMem;
            session()->put("mem",$mem);
        }

        $Arrx = json_encode($Arrx);
        $Arry = json_encode($Arry);

        #$command = 'python "'.public_path().'\python\vandermonde.py" '." ".$Arrx." ".$Arry;
        #$command = escapeshellcmd('python3.6 -V');
        #$output = explode("\n", substr_replace(shell_exec($command),"",-2));
        $command = 'python "'.public_path().'\python\vandermonde.py" '." ".$Arrx." ".$Arry;
        exec($command, $output);
        $data = [];

        $mem = session()->get("mem");
        $data["mem"] = $mem;
        $data["checkMem"] = "true";
        $data["storage"] = "false";

        #dd($output);
        $data["title"] = __('vandermonde_method.title');
        if (substr($output[0],7,5) == "Error"){
            $data["solution"] = "false";
            $data["message"] = substr($output[0],7,strlen($output[0])-9);
        }else{
            $data["solution"] = "true";
            $data["dimension"] = $dimension;
            $json = json_decode($output[0], true);
            $v_matrix = $json["v_matrix"];
            $coef = $json["coef"];
            $polynomial = $json["polynomial"];

            
            $v_matrix = $this->rebuildArray($v_matrix);

            $temporal = substr($coef,1,strlen($coef)-2);
            $temporal = str_replace("'","",$temporal);
            $temporal = explode(" ",$temporal);
        
            $data["v_matrix"] = $v_matrix;
            $data["coef"] = $temporal;
            $data["polynomial"] = $polynomial;
        }

        return view('vandermondeMethod')->with("data",$data);
    }

    public function rebuildArray($array){
        $aux_array = [];
        $aux2_array = [];
            
        for ($i=0; $i < count($array) ; $i++) { 
            
            $temporal = substr($array[$i],1,strlen($array[$i])-2);
            $temporal = str_replace("'","",$temporal);
            $temporal = explode(" ",$temporal);
            array_push($aux_array, $temporal);
           
        }

        return $aux_array;
    }

    public function storage($storage,$method){
        $data = [];
        $data["checkMem"] = "true";
        $data["title"] = __('vandermonde_method.title');
        $data["check"] = "false";
        $data["solution"] = "false";
        $mem = session()->get("mem");
        $data["mem"] = $mem;
        $information = $data["mem"][$method][$storage];
        $data["information"] = $information;
        $data["storage"] = "true";
        //dd($data);
        return view('vandermondeMethod')->with("data",$data);
    }
}