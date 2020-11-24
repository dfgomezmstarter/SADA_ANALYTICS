@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<div class="container" align="center">
    <h2>Muller Method</h2>
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
                    <li>The iteration number must be positive and less than 200</li>
                    <li>If you wish you can leave the field x2 empty, the system will determine x2 as the midpoint of x0 and x1</li>
                    <li>On the number line x0 must be before x1.</li>
                </div>
            </div><br>
            <form method="POST" action="{{ route('muller_method') }}" class="form">
                    @csrf
                    @if($data["storage"] == "true")
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>\[f(x)\]</label>
                                <input type="text" class="form-control" placeholder="{{$data['information'][0]}}" name="function" value="{{$data['information'][0]}}" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[x0\]</label>
                                <input type="number" class="form-control" placeholder="Enter x0" name="x_0" step="any" value="{{ empty($data['x_0']) ? '' : $data['x_0'] }}" required />
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[x1\]</label>
                                <input type="number" class="form-control" placeholder="Enter x1" name="x_1" step="any" min="0" required value="{{ empty($data['x_1']) ? '' : $data['x_1'] }}"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>\[x2\]</label>
                                <input type="number" class="form-control" placeholder="Enter x2" name="x_2" step="any" min="0" value="{{ empty($data['x_2']) ? '' : $data['x_2'] }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[T\]</label>
                                <input type="number" class="form-control" placeholder="Enter Tolerance" name="tolerance" required step="any" value="{{ empty($data['tolerance']) ? '' : $data['tolerance'] }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[n\]</label>
                                <input type="number" class="form-control" placeholder="Enter Iterations" name="iterations" min="1" max="200" required value="{{ empty($data['iterations']) ? '' : $data['iterations'] }}" />
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox col-md-12">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save function after calculating</label>
                        </div><br>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-outline-success btn-block">{{ __('muller.label.calculate') }}</button>
                            </div>
                        </div>
                        <a class="btn btn-outline-primary btn-block" href="{{ route('muller') }}">Try with another function</a>
                    @else
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>\[f(x)\]</label>
                                <input type="text" class="form-control" placeholder="Enter Function" name="function" required value="{{ empty($data['function']) ? '' : $data['function'] }}" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[x0\]</label>
                                <input type="number" class="form-control" placeholder="Enter x0" name="x_0" step="any" value="{{ empty($data['x_0']) ? '' : $data['x_0'] }}" required />
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[x1\]</label>
                                <input type="number" class="form-control" placeholder="Enter x1" name="x_1" step="any" min="0" value="{{ empty($data['x_1']) ? '' : $data['x_1'] }}" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>\[x2\]</label>
                                <input type="number" class="form-control" placeholder="Enter x2" name="x_2" step="any" min="0" value="{{ empty($data['x_2']) ? '' : $data['x_2'] }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[T\]</label>
                                <input type="number" class="form-control" placeholder="Enter Tolerance" name="tolerance" required step="any" value="{{ empty($data['tolerance']) ? '' : $data['tolerance'] }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>\[n\]</label>
                                <input type="number" class="form-control" placeholder="Enter Iterations" name="iterations" min="1" max="200" value="{{ empty($data['iterations']) ? '' : $data['iterations'] }}" required />
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox col-md-12">
                            <input type="checkbox" class="custom-control-input" id="customControlInline" name="save" value="save">
                            <label class="custom-control-label" for="customControlInline">Save function after calculating</label>
                        </div><br>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-outline-success btn-block">{{ __('muller.label.calculate') }}</button>
                            </div>
                        </div>
                        <br>
                    @endif
            </form>
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
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('storage_muller',['storage'=> $j,'method' => 0]) }}">Use Storage {{$j}}</a><br> 
                        \[{{$data["mem"][0][$j][0]}}\]
                        <br>
                    @endfor
                </div>
            </div>
        @endif
    </div>
    @if ($data["check"] == "true")
        <div class="card">
            <div class="card-header">
                <h2>{{ __('muller.label.initialData') }}</h2>
                \[x0 = {{ $data["x_0"] }}\]
                \[x1 = {{ $data["x_1"] }}\]
                \[x2 = {{ $data["x_2"] }}\]
                \[n = {{ $data["iterations"] }}\]
                \[f(x) = {{ $data["function"] }}\]
                \[T = {{ $data["tolerance"] }}\]
            </div>
            <div class="card-body">
                <h2>Solution</h2>
                <div class="row justify-content-center">
                    <table class="table table-striped text-center table-BusquedasIncrementales">
                        <thead>
                            <tr>
                                <th>\[ Iteration \]</th>
                                <th>\[ Xm \]</th>
                                <th>\[ f(Xm) \]</th>
                                <th>\[ Error \]</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data["json"] as $iteration)
                                <tr>
                                    <th>\[{{ $iteration[0] }}\]</th>
                                    <th>\[{{ $iteration[1] }}\]</th>
                                    <th>\[{{ $iteration[2] }}\]</th>
                                    <th>\[{{ $iteration[3] }}\]</th>
                                </tr>
                                @if ($loop->last)
                                    <tr>
                                        <th colspan="4">{{ __('muller.root') }}\[{{ $iteration[1] }}\]</th>
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