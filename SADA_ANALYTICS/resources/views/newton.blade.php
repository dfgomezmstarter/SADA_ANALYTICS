@extends('layouts.master')

@section("title", $data["title"])  

@section('content')
<div class="container" align="center">
<h2>{{ __('newton.title') }}</h2>
    @include('layouts.message')
    <div class="row justify-content-center">
        <div class="col-md-6" style="float: left;">
            <p>
                <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-info-circle"></i> Help</a>
            </p>
            <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body">
                    <li>The initial values must exist in the function.</li>
                    <li>The function must be continuous and differentiable.</li>
                    <li>Tolerance must have a positive value.</li>
                    <li>The iteration number must be positive and lower than 200</li>
                    <li>Is necessary have a sign change in the function, because the method use the bisection method</li>
                </div>
            </div><br>
            <form method="POST" action="{{ route('newton_method') }}" class="form">
                    @csrf
                    @if($data["storage"] == "true")
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.f_function') }}\]</label>
                                <input type="text" class="form-control" placeholder="{{$data['information'][0]}}" value="{{$data['information'][0]}}" name="f_function" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.df_function') }}\]</label>
                                <input type="text" class="form-control" placeholder="{{ __('newton.input.df_function') }}" value="{{ empty($data['df_function']) ? '' : $data['df_function'] }}" name="df_function" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.initial_x') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.initial_x') }}" value="{{ empty($data['initial_x']) ? '' : $data['initial_x'] }}" name="initial_x" step="any" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.tolerance') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.tolerance') }}" value="{{ empty($data['tolerance']) ? '' : $data['tolerance'] }}" name="tolerance" step="any" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.iterations') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.iterations') }}" value="{{ empty($data['iterations']) ? '' : $data['iterations'] }}" name="iterations" step="1" min="1" max="200" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-outline-success btn-block">{{ __('newton.calculate') }}</button>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox col-md-12">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save Function after calculating</label>
                        </div><br><br>
                        <a class="btn btn-outline-primary btn-block" href="{{ route('newton') }}">Try with another function</a>
                    @else
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.f_function') }}\]</label>
                                <input type="text" class="form-control" placeholder="{{ __('newton.input.f_function') }}" value="{{ empty($data['f_function']) ? '' : $data['f_function'] }}" name="f_function" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.df_function') }}\]</label>
                                <input type="text" class="form-control" placeholder="{{ __('newton.input.df_function') }}" value="{{ empty($data['df_function']) ? '' : $data['df_function'] }}" name="df_function" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.initial_x') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.initial_x') }}" value="{{ empty($data['initial_x']) ? '' : $data['initial_x'] }}" name="initial_x" step="any" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.tolerance') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.tolerance') }}" value="{{ empty($data['tolerance']) ? '' : $data['tolerance'] }}" name="tolerance" step="any" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>\[{{ __('newton.label.iterations') }}\]</label>
                                <input type="number" class="form-control" placeholder="{{ __('newton.input.iterations') }}" value="{{ empty($data['iterations']) ? '' : $data['iterations'] }}" name="iterations" step="1" min="1" max="200" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-outline-success btn-block">{{ __('newton.calculate') }}</button>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox col-md-12">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save Function after calculating</label>
                        </div><br><br>
                    @endif
            </form>
            @if (!empty($data["f_function"]))
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('function_plotter_url') }}" class="form" target="_blank">
                        @csrf    
                        <input type="hidden" name="f_function" value="{{ $data['f_function'] }}">
                        <button type="submit" class="btn btn-info btn-block">Graph f(x)</button>
                    </form>
                </div>
                @if (!empty($data["df_function"]))
                <div class="col-md-6">
                    <form method="POST" action="{{ route('function_plotter_url') }}" class="form" target="_blank">
                        @csrf    
                        <input type="hidden" name="f_function" value="{{ $data['df_function'] }}">
                        <button type="submit" class="btn btn-info btn-block">Graph f'(x)</button>
                    </form>
                </div>
                @endif
            </div>
            <br>
            @endif  
        </div>
        @if ($data["checkMem"] == "true" and $data["mem"][0][0] != 0)
            <div class="col-md-6" style="float: right;">
                <p>
                    @if (count($data["mem"][0]) > 1)
                        <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fa fa-info-circle"></i> Functions Saved</a>
                    @endif 
                </p>
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    @for($j = 1; $j < count($data["mem"][0]); $j++)
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('storage_newton',['storage'=> $j,'method' => 0]) }}">Use Storage {{$j}}</a><br> 
                        \[{{$data["mem"][0][$j][0]}}\]
                        <br>
                    @endfor
                </div>
            </div>
        @endif
    </div>
    @if ($data["solution"] == "true")
        <div class="card">
            <div class="card-header">
                <h1>{{ __('newton.initial_data') }}</h1>
                \[{{ __('newton.label.f_function') }}: {{ $data['f_function'] }}\]
                \[{{ __('newton.label.df_function') }}: {{ $data['df_function'] }}\]
                \[{{ __('newton.label.initial_x') }}: {{ $data['initial_x'] }}\]
                \[{{ __('newton.label.tolerance') }}: {{ $data['tolerance'] }}\]
                \[{{ __('newton.label.iterations') }}: {{ $data['iterations'] }}\]
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <table class="table table-striped text-center table-BusquedasIncrementales">
                        <thead>
                            <tr>
                                <th>\[{{ __('newton.table.iteration') }}\]</th>
                                <th>\[{{ __('newton.table.xi') }}\]</th>
                                <th>\[{{ __('newton.table.f_xi') }}\]</th>
                                <th>\[{{ __('newton.table.error') }}\]</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data["table"] as $iteration)
                                <tr>
                                    <th>\[{{ $iteration[0] }}\]</th>
                                    <th>\[{{ $iteration[1] }}\]</th>
                                    <th>\[{{ $iteration[2] }}\]</th>
                                    <th>\[{{ $iteration[3] }}\]</th>
                                </tr>
                                @if ($loop->last)
                                <tr>
                                    <th colspan="4">{{ __('newton.root') }}\[{{ $iteration[1] }}\]</th>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif      
</div>
@endsection