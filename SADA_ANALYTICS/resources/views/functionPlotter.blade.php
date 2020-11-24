@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<head>
    <script type='text/javascript'>
    window.onload = function(){
        document.getElementById('eval-error').style.display = 'none';
        document.getElementById('plot-error').style.display = 'none';
        document.getElementById('form-eval').onsubmit = function (event) {
            event.preventDefault();
            evaluate();
        };

        document.getElementById('form').onsubmit = function (event) {
            event.preventDefault();
            draw();
        };
        function draw() {
            try {
            functionPlot({
                target: '#plot',
                data: [{
                fn: document.getElementById('eq').value,
                sampler: 'builtIn',  // this will make function-plot use the evaluator of math.js
                graphType: 'polyline'
                }]
            });
            document.getElementById('plot-error').style.display = 'none';
            }
            catch (err) {
            console.log(err);
            document.getElementById('plot-error').innerHTML ='<div class="alert alert-danger alert-dismissible fade show" role="alert">' + err+ '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            document.getElementById('plot-error').style.display = 'block';  
            }
            draw();
        }

        function evaluate() {
            try {
                x_val = document.getElementById('x_value').value;
                let scope = {x: x_val};
                function_to_eval = document.getElementById('function_eval').value;
                const node1 = math.parse(function_to_eval);
                let result = node1.compile().evaluate(scope);
                eval_div = document.getElementById('evaluate');
                console.log((x_val));
                to_render = 'f('+(x_val)+') = '+ (result);
                katex.render(to_render, eval_div, {throwOnError: false});
                document.getElementById('eval-error').style.display = 'none';
                }
                catch (err) {
                console.log(err);
                document.getElementById('eval-error').innerHTML ='<div class="alert alert-danger alert-dismissible fade show" role="alert">' + err+ '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                document.getElementById('eval-error').style.display = 'block';
                }
        }

}

    </script>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                {{ __('function_plotter.plotter_title') }}
                </div>
                <div class="card-body">
                        <form id="form" class="form">
                            <div class="form-row">
                                <label for="eq" style="padding-right:10px;" >{{ __('function_plotter.function') }}</label>
                                <input type="text" id="eq" value="{{ empty($data['function']) ? 'sin(x)' : $data['function'] }}"/>
                                <input type="submit" value="{{ __('function_plotter.graph') }}" class="btn btn-outline-success">
                            </div>
                        </form>
                        <div id="plot"></div>
                        <div id="plot-error">

                        </div>
                        <p>{{ __('function_plotter.library') }} <a href="https://github.com/maurizzzio/function-plot">https://github.com/maurizzzio/function-plot</a></p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                {{ __('function_plotter.evaluator_title') }}
                </div>
                <div class="card-body">
                        <form id="form-eval" class="form">
                            <div class="form-row">
                                <label for="function_eval" style="padding-right:10px;" >{{ __('function_plotter.function') }}</label>
                                <input type="text" id="function_eval" />
                            </div>
                            <br>
                            <div class="form-row">
                                <label for="x_value" style="padding-right:10px;" >{{ __('function_plotter.x_value_label') }}</label>
                                <input type="text" id="x_value"/>
                                <input type="submit" value="{{ __('function_plotter.evaluate') }}" class="btn btn-outline-success btn-sm">
                            </div>
                        </form>
                        <hr>
                        <div id="evaluate"></div>
                        <div id="eval-error">
                           
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection