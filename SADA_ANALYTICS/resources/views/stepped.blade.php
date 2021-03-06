@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<head>
    <script type='text/javascript'>
        function addFields(){
            var number = document.getElementById("dimension").value;
            var container_matrix = document.getElementById("matrix");
            var container_vector = document.getElementById("vector");
            while (container_matrix.hasChildNodes()) {
                container_matrix.removeChild(container_matrix.lastChild);
            }
            while (container_vector.hasChildNodes()) {
                container_vector.removeChild(container_vector.lastChild);
            }
            if (number > 10){
                number = 10;
            }
            if (number <= 2){
                number = 2;
            }
            for (i=0;i<number;i++) {
                for (j=0;j<number;j++){
                    container_matrix.appendChild(document.createTextNode(""));
                    var input = document.createElement("input");
                    input.type = "number";
                    input.name = "matrix" + i + j;
                    input.style = "width : 110px;";
                    input.step = "any";
                    input.required = true;
                    container_matrix.appendChild(input);
                }
                container_matrix.appendChild(document.createElement("br"));
                container_matrix.appendChild(document.createElement("br"));
                container_vector.appendChild(document.createTextNode(""));
                var vector = document.createElement("input");
                vector.type = "number";
                vector.name = "vector" + i ;
                vector.style = "width : 110px;";
                vector.step = "any";
                vector.required = true;
                container_vector.appendChild(vector);
                container_vector.appendChild(document.createElement("br"));
                container_vector.appendChild(document.createElement("br"));
            }
            document.getElementById("separador").style.display = 'block';
            document.getElementById("matrix_a").style.display = 'block';
            document.getElementById("vector_b").style.display = 'block'; 
            document.getElementById("solve").style.display = 'block';
            document.getElementById("save").style.display = 'block';
            
        }
    </script>
</head>
<div class="container" align="center">
    <h2>Stepped Partial Pivot Method</h2>
    @include('layouts.message')
    <div class="row justify-content-center sizeMatrix">
        <div class="col-md-6" style="float: left;">
            <p>
                <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-info-circle"></i> Help</a>
            </p>
            <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body">
                    <li>Make sure all the fields in the array are filled.</li>
                    <li>The determinant of the matrix must not be 0.</li>
                    <li>The matrix dimension must not be less than 2 and must not be greater than 10.</li>
                </div>
            </div><br>
            <form method="POST" action="{{route('stepped_method')}}" class="form">
                @csrf
                @if($data["storage"] == "true")
                    <div class="text-align">
                        \[ A = \]<br>
                        @for($i = 0; $i < count($data["information"][0][0]); $i++)
                            @for($j = 0; $j < count($data["information"][0][0]); $j++)
                            <input type="number" step="any" name="matrix{{$i}}{{$j}}" style="width: 110px" placeholder="{{$data['information'][0][$i][$j]}}" value="{{$data['information'][0][$i][$j]}}">    
                            @endfor <br><br>
                        @endfor
                        <div> {{ __('gaussian_method.separator') }}</div>
                        \[ b = \]<br>
                        @for($i = 0; $i < count($data["information"][0][0]); $i++)
                            <input type="number" step="any" name="vector{{$i}}" style="width: 110px" placeholder="{{$data['information'][1][$i]}}" value="{{$data['information'][1][$i]}}"> <br><br>
                        @endfor
                        <div class="form-group col-md-12">
                            <input type="number" id="dimension" min="2" class="form-control" placeholder="{{$data['information'][2]}}" value="{{$data['information'][2]}}" name="n" step="any" required hidden="true" />
                        </div>
                        <div class="custom-control custom-checkbox col-md-12">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save Matrix</label>
                        </div><br><br>
                        <button type="submit" class="btn btn-outline-success btn-block">Solve</button>
                        <a class="btn btn-outline-primary btn-block" href="{{ route('stepped') }}">Try with another matrix</a>
                    </div>
                @else
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>\[ Dimension \]</label>
                            <input type="number" id="dimension" min="2" class="form-control" placeholder="Matrix dimension" name="n" step="any" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <a id="filldetails" onclick="addFields()" class="btn btn-outline-primary btn-block">Create Matrix</a> 
                        </div>
                        <div class="custom-control custom-checkbox col-md-12" style="display: none" id="save">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save Matrix</label>
                        </div><br><br>
                        <div class="form-group col-md-12">
                            <button id="solve" type="submit" class="btn btn-outline-success btn-block metodo">Solve</button> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id="matrix_a" class="text-align metodo">\[ A = \]</div>
                            <div id="matrix" class="text-align"> </div>
                        </div>
                    </div>
                    
                    <div id="separador" class="text-align metodo"> {{ __('gaussian_method.separator') }}</div>
                    <div class="row">
                        <div class="col">
                            <div id="vector_b" class="text-align metodo">\[ b = \]</div>
                            <div id="vector" class="text-align"> </div></br>
                        </div>
                    </div>

                @endif
            </form>
        </div>
        @if ($data["checkMem"] == "true" and $data["mem"][1][0] != 0)
            <div class="col-md-6" style="float: right;">
                <p>
                    @if (count($data["mem"][1]) > 1)
                        <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fa fa-info-circle"></i> Matrices Saved</a>
                    @endif 
                </p>
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    @for($j = 1; $j < count($data["mem"][1]); $j++)
                        <a class="btn btn-outline-primary" href="{{ route('storage_stepped',['storage'=> $j,'method' => 1]) }}">Use Storage {{$j}}</a> <br><br>
                        $$A = \begin{bmatrix}
                        @for($z = 0; $z < count($data["mem"][1][$j][0]); $z++)
                            @for($f = 0; $f < count($data["mem"][1][$j][0][$z]); $f++)
                                @if($f != count($data["mem"][1][$j][0][$z])-1)
                                    {{$data["mem"][1][$j][0][$z][$f]}} & 
                                @else 
                                    {{$data["mem"][1][$j][0][$z][$f]}} \\
                                @endif  
                            @endfor
                        @endfor
                        \end{bmatrix}$$
                        $$b = \begin{bmatrix}
                        @for($z = 0; $z < count($data["mem"][1][$j][1]); $z++)
                            {{$data["mem"][1][$j][1][$z]}} \\
                        @endfor
                        \end{bmatrix}$$<br>
                    @endfor
                </div>
            </div>
        @endif
    </div><br>
    @if ($data["solution"] == "true")
        <div class="card">
            <div class="card-header">
                <h1>Solution</h1>
            <br>
            </div>
            <div class="card-body">
                <div> 
                    @for ($i = 0; $i < count($data["matrix"]); $i++)
                        <b><em>Step {{$i}}</em></b>
                        $$A = \begin{pmatrix}
                        @for ($j = 0; $j < count($data["matrix"][$i]); $j++)
                            
                            @for ($v = 0; $v < count($data["matrix"][$i][$j]); $v++)
                                @if($v == count($data["matrix"][$i][$j])-1)
                                    {{ $data["matrix"][$i][$j][$v]}} \\
                                @else
                                    {{ $data["matrix"][$i][$j][$v]}} &
                                @endif
                            @endfor
                            
                        @endfor
                        \end{pmatrix}$$ 
                    @endfor

                    <b><em>Solution</em></b>
                    $$X = \begin{pmatrix}
                    @foreach ($data["xSolution"][0] as $solution)
                        @if($loop->last)
                            {{$solution}}
                        @else
                            {{$solution}} \\
                        @endif
                    @endforeach
                    \end{pmatrix}$$
        
                </div>
            </div>
        </div>
    @endif
</div>
@endsection