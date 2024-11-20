@include('includes.header')

<div class="container-fluid">

        <div class="row mb-3">
            <div class="col-md-6">
            <button class="btn btn-success" data-toggle="modal" data-target="#cashInModal"><i class="fa-solid fa-arrow-right-to-bracket"></i> Cash In </button>
            <button class="btn btn-danger" data-toggle="modal" data-target="#cashOutModal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cash Out</button>

            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <div>
                <button onclick="downloadTableAsExcel()" class="btn btn-success mb-4">Download Excel</button>
                    <div class="btn btn-warning py-2 px-3 ml-3">
                        <p class="mb-0" style="color:#222222;">Total Cash</p>
                        <h5 class="h5" style="color:#222222;font-weight:700;">
                        @php
                            $total = 0;
                            $totalIn = 0;
                            $totalOut = 0;
                        @endphp

                        @foreach($cashRegister as $ca)
                            @if($ca->cash_flow == 1)
                                @php
                                    $totalIn += $ca->payments;
                                @endphp
                            @elseif($ca->cash_flow == 0)
                                @php
                                    $totalOut += $ca->payments;
                                @endphp
                            @endif
                        @endforeach

                        @php
                            $total = $totalIn - $totalOut;
                        @endphp

                        {{ $total }}
                        </h5>
                    </div>
                </div>
                
            </div>
        </div>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cash Register</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Guest Name</th>
                        <th>Guest Code</th>
                        <th>Room/Bed no.</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                        <th>Name of Transaction</th>
                        <th>Payment Date</th>
                        <th>Comments</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Guest Code</th>
                        <th>Room/Bed no.</th>
                        <th>Amount</th>
                        <th>Name of Transaction</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot> -->
                <tbody>
                    @php
                        $count =1;
                    @endphp
                    @foreach($cashRegister as $ca)
                    <tr>
                        <td>{{$count}}</td>
                        
                        @if($ca->guest_id == 'N/A')
                            <td>{{$ca->guest_id}}</td>
                        @else
                            @foreach($guests as $gs)
                                @if($ca->guest_id == $gs->id)
                                    <td>{{$gs->first_name}} {{$gs->last_name}}</td>
                                @endif
                            @endforeach
                        @endif    
                        
                        <td>{{$ca->code}}</td>
                        @if($ca->guest_id == 'N/A')
                            <td>{{$ca->guest_id}}</td>
                        @else
                            @foreach($guests as $gs)
                                @if($ca->guest_id == $gs->id)
                                    <td>{{$gs->room_number}}/{{$gs->bed_number}}</td>
                                @endif
                            @endforeach
                        @endif
                        <td>
                            {{$ca->payments}} 
                            
                        </td>
                        <td>
                            @if($ca->cash_flow == 1)
                                <span class="btn btn-success" style="padding: 0px 10px;margin-left: 10px;">In</span>
                            @elseif($ca->cash_flow == 0)
                                <span class="btn btn-danger"  style="padding: 0px 10px;margin-left: 10px;">Out</span>
                            @endif
                        </td>
                        <td>{{$ca->payment_by}}</td>
                        <!-- @foreach($user as $us)
                            @if($ca->user_id == $us->id)
                                <td>{{$us->fname}}</td>
                            @endif
                        @endforeach -->
                        <td>{{ $ca->created_at->format('F j, Y') }}</td>
                        <td>{{ $ca->cash_comments}}</td>
                        <td>
                            <a href="{{route('deleteCashRegister',$ca->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete register">
                                <span class="text"><i class="fa-solid fa-trash"></i></span>
                            </a>
                        </td>
                        @php
                            $count++;
                        @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>


<!-- CashOut popup -->
<div class="modal fade" id="cashOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cash Out</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close-button-cash-out-modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <!-- <label>Choose Cash out reason</label><br>
                <input type="radio" name="cash_out_reason" id="gust" value="gust" onclick="showSection('gust')">
                <label for="gust">Gust</label>
                <input type="radio" name="cash_out_reason" id="other" value="other" onclick="showSection('other')">
                <label for="other">Other</label> -->
                <div class="form-group">
                    <label>Select cash out by*</label>
                    <select name="money_by" id="money_by_out" class="form-control">
                        <option value="none">Select cash out by</option>
                        <option value="Arman">Money Out By Arman</option>
                        <option value="Tigran">Money Out By Tigran</option>
                        <option value="Other">Money Out By Other</option>
                    </select>
                </div>

                <!-- <div class="row" id="guest-choose">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Guest Code*</label>
                            <input type="text" id="guest-code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount*</label>
                            <input type="text" id="guest-amount" class="form-control">
                        </div>
                    </div>
                </div> -->

                <div id="other-choose">

                    <div class="form-group">
                        <label for="">Comments for cash out*</label>
                        <textarea class="form-control" id="other-cash-out-comments"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Amount*</label>
                        <input type="text" id="other-amount" class="form-control">
                    </div>
                </div>

            </div>
            <script>
                // function showSection(option) {
                //     document.getElementById('guest-choose').style.display = (option === 'gust') ? 'flex' : 'none';
                //     document.getElementById('other-choose').style.display = (option === 'other') ? 'block' : 'none';
                // }
                // document.addEventListener('DOMContentLoaded', function() {
                //     document.getElementById('gust').checked = true;
                //     showSection('gust');
                // });
            </script>

            <div class="modal-footer" style="display:block;">
                <div class="form-group">
                    <button class="btn btn-danger mt-2" id="cash-out-btn" type="button">Cash Out</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- CashOut popup -->


<!-- CashIn popup -->
<div class="modal fade" id="cashInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cash In</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close-button-cash-in-modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <label>Choose Cash in reason</label><br>
                <input type="radio" name="cash_in_reason" id="gust-in" value="gust" onclick="showSectionin('gust')">
                <label for="gust">Gust</label>
                <input type="radio" name="cash_in_reason" id="other-in" value="other" onclick="showSectionin('other')">
                <label for="other">Other</label>

                <div class="form-group">
                    <label>Select cash in by*</label>
                    <select name="money_by" id="money_by_in" class="form-control">
                        <option value="none">Select cash in by</option>
                        <option value="Arman">Money In By Arman</option>
                        <option value="Tigran">Money In By Tigran</option>
                        <option value="Other">Money In By Other</option>
                    </select>
                </div>

                <div class="row" id="guest-choose-in">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Guest Code*</label>
                            <input type="text" id="guest-in-code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount*</label>
                            <input type="text" id="guest-in-amount" class="form-control">
                        </div>
                    </div>
                </div>

                <div id="other-choose-in" style="display:none;">
                    
                    <div class="form-group">
                        <label for="">Comments for cash in*</label>
                        <textarea class="form-control" id="other-cash-in-comments"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Amount*</label>
                        <input type="text" id="other-in-amount" class="form-control">
                    </div>
                </div>

            </div>
            <script>
                function showSectionin(option) {
                    document.getElementById('guest-choose-in').style.display = (option === 'gust') ? 'flex' : 'none';
                    document.getElementById('other-choose-in').style.display = (option === 'other') ? 'block' : 'none';
                }
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('gust-in').checked = true;
                    showSection('gust');
                });
            </script>

            <div class="modal-footer" style="display:block;">
                <div class="form-group">
                    <button class="btn btn-success mt-2" id="cash-in-btn" type="button">Cash In</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- CashIn popup -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
function downloadTableAsExcel() {
    // Select the HTML table element
    var table = document.getElementById("dataTable");

    // Convert HTML table to a worksheet
    var workbook = XLSX.utils.table_to_book(table, { sheet: "Cash Register" });

    // Generate Excel file and trigger download
    XLSX.writeFile(workbook, "cash_register.xlsx");
}
</script>
@include('includes.footer')