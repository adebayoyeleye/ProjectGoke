@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!!
                    
                    
                    <div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Transactions</div>
                            <div class="panel-body">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach (Auth::user()->pledges as $pledge)
                                                   @foreach ($pledge->receives as $dueReceive)
                                                        <tr>
                                                            <td>{{ $dueReceive->id }}</td>
                                                            <td>{{ $dueReceive->pivot->amount }}</td>
                                                            <td>{{ $dueReceive->pivot->status }}</td>
                                                            <td>
                                                                <a href="#" class=" btn btn-primary" onclick='$.callActionForm("#proofimageupload", {!! '"' . $pledge->id . " " . $dueReceive->id . '"' !!})'>Upload Proof</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach  
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <hr/>
                                
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach (Auth::user()->receives as $receive)
                                                   @foreach ($receive->pledges as $duePledge)
                                                        <tr>
                                                            <td>{{ $duePledge->id }}</td>
                                                            <td>{{ $duePledge->pivot->amount }}</td>
                                                            <td>{{ $duePledge->pivot->status }}</td>
                                                            <td>
                                                                @if ($duePledge->pivot->status == "Awaiting confirmation")
                                                                    <!--<a href="#" class=" btn btn-primary" onclick='$.callActionForm("#divviewproof", {!! '"' . storage_path("app/".$duePledge->pivot->proof_image_path) . '"' !!})'>See Proof</a>-->
                                                                    <a href="#" class=" btn btn-primary" onclick='$.callActionForm("#divviewproof", {!! '"' . $duePledge->id . " " . $receive->id . '"' !!} , "{{ url( $duePledge->pivot->proof_image_path ) }}")'>See Proof</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach  
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Pledges</div>
                                <div class="panel-body">
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (Auth::user()->pledges as $pledge)
                                                    <tr>
                                                        <td>{{ $pledge->id }}</td>
                                                        <td>{{ $pledge->amount }}</td>
                                                        <td>{{ $pledge->status }}</td>
                                                    </tr>    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <a href="#" class=" btn btn-primary" onclick='$.callActionForm("#makepledgeform")'>Make a Pledge</a>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Receives</div>
                                <div class="panel-body">
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (Auth::user()->receives as $receive)
                                                    <tr>
                                                        <td>{{ $receive->id }}</td>
                                                        <td>{{ $receive->amount }}</td>
                                                        <td>{{ $receive->status }}</td>
                                                    </tr>    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <a href="#" class=" btn btn-primary" onclick='$.callActionForm("#makereceiveform")'>Request Receive</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
<!--                <div id="overlay-back"></div>-->
                
                <div id="makepledgeform" style="display: none" class="centered resetVisibles overlay">
                    <form action="/pledge" method="POST" class="form-group">
                       {{ csrf_field() }}
                        <input type="text" name="amount" placeholder="Pledge Amount" required><br/>
                        <input type="submit" name="pledge" value="Make Pledge" class="btn btn-primary">
                    </form>
                </div>
                
                <div id="makereceiveform" style="display: none" class="centered resetVisibles overlay">
                    <form action="/receive" method="POST" class="form-group">
                       {{ csrf_field() }}
                        <input type="text" name="amount" placeholder="Receive Amount" required><br/>
                        <input type="submit" name="receive" value="Request Receive" class="btn btn-primary">
                    </form>
                </div>
                
                <div id="proofimageupload" style="display: none" class="centered resetVisibles overlay">
                    <form action="/proof" method="post" id="proofform" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <legend>Form Title</legend>

                        <div class="form-group">
                            <label for="">Upload proof of payment:</label>
                            <input id="image-file" type="file" name="proof">
                        </div>
                        <button type="submit" class="btn btn-primary">save</button>
                        <a href="{{'/'}}" class="btn btn-primary">back</a>
                    </form>
                    <img name="youravatar" src="">
                </div>
                
                <div id="divviewproof" style="display: none" class="centered resetVisibles overlay">
                    <div>
                        <img id="proofimgview" src="" >
                    </div>
                    <form action="/confirm" method="POST" class="form-group" id="confirmform">
                       {{ csrf_field() }}
                        <br/>
                        <input type="submit" name="confirm" value="Confirm Payment" class="btn btn-primary">
                        <input type="submit" name="confirm" value="Decline Confirmation" class="btn btn-primary">
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
