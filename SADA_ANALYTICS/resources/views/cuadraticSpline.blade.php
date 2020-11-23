@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<head>
    <script type='text/javascript'>
        function addFields(){
            // Number of inputs to create
            var number = document.getElementById("dimension").value;
            // Container <div> where dynamic content will be placed
            var container_matrix = document.getElementById("matrix");
            var container_vector = document.getElementById("vector");
            // Clear previous contents of the container
            while (container_matrix.hasChildNodes()) {
                container_matrix.removeChild(container_matrix.lastChild);
            }
            while (container_vector.hasChildNodes()) {
                container_vector.removeChild(container_vector.lastChild);
            }
            if (number>1) {
                for (i=0;i<number;i++) {
                    // Append a node with a random text
                        container_matrix.appendChild(document.createTextNode(""));
                        // Create an <input> element for matrix A, set its type and name attributes
                        var input = document.createElement("input");
                        input.type = "number";
                        input.name = "x" + i;
                        input.style = "width : 110px;";
                        input.step = "any";
                        input.required = true;
                        container_matrix.appendChild(input);
                    // Append a node with a random text
                    container_vector.appendChild(document.createTextNode(""));
                    // Create an <input> element for vector B, set its type and name attributes
                    var vector = document.createElement("input");
                    vector.type = "number";
                    vector.name = "y" + i ;
                    vector.style = "width : 110px;";
                    vector.step = "any";
                    vector.required = true;
                    container_vector.appendChild(vector);
                }
                document.getElementById("matrix_a").style.display = 'block';
                document.getElementById("vector_b").style.display = 'block'; 
                document.getElementById("solve").style.display = 'block';
            }
        }
    </script>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{route('cuadratic_spline_method')}}" class="form">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Dimension</label>
                        <input type="number" id="dimension" min="2" class="form-control" placeholder="Dimension" name="n" step="any" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <a id="filldetails" onclick="addFields()" class="btn btn-outline-primary btn-block">Create arrays</a> 
                    </div>
                    <div class="form-group col-md-12">
                        <button id="solve" type="submit" class="btn btn-outline-success btn-block metodo">Solve</button> 
                    </div>
                </div>
                <div id="matrix_a" class="text-align metodo"> \[ x = \] </div>
                <div id="matrix" class="text-align"> </div>
                

                <div id="vector_b" class="text-align metodo"> \[F(x) = \] </div>
                <div id="vector" class="text-align"> </div>
            </form>
        </div>
    </div><br>
    @if ($data["check"] == "true")
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Initial Data</h2>
                    <b>\[X = [
                    @foreach ($data["arrx"] as $x)
                        @if($loop->last)
                            {{$x}}
                        @else
                            {{$x}},
                        @endif
                    @endforeach
                    ]\]
                    \[Y = [
                    @foreach ($data["arry"] as $y)
                        @if($loop->last)
                            {{$y}}
                        @else
                            {{$y}},
                        @endif
                    @endforeach
                    ]\]
                </div>
                <div class="card-body">

                @if ($data["error"][0] == false)
                    <h2>Coefficients</h2>
                    <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">\[i\]</th>
                    <th scope="col">\[Coeff \space 1\]</th>
                    <th scope="col">\[Coeff \space 2\]</th>
                    <th scope="col">\[Coeff \space 3\]</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($data["tracers"][0]); $i+=3)
                    <tr>
                        <th scope="row">\[{{$i/3}}\]</th>
                            <td>\[{{$data["tracers"][0][$i]}}\]</td>
                            <td>\[{{$data["tracers"][0][$i+1]}}\]</td>
                            <td>\[{{$data["tracers"][0][$i+2]}}\]</td>
                        </tr>
                    @endfor
                </tbody>
                </table>
                    <h1>Tracers</h1>
                    @for($i = 0; $i < count($data["tracers"][0]); $i+=3)
                            \[ {{$i/3}}: ({{$data["tracers"][0][$i]}})x^2 + ({{$data["tracers"][0][$i+1]}})x \\ 
                            + ({{$data["tracers"][0][$i+2]}}) \\ \]

                    @endfor
                @else
                    <p>Error: {{ $data["error"][0] }}</p> 
                @endif
                </div>
            </div>
        </div> 
    </div> 
    @endif
</div>
@endsection