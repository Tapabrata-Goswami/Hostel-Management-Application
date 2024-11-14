
</div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>





    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <!-- <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script> -->

    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

    <script>

        $(document).ready(function(){

            // Comments Functionality---------------
            let guestId, comment;
            $(".comment-popup-open").on("click", function(){
                guestId = $(this).attr('id');
                viewcommnts(guestId);
            });
            $("#submit_comment").on("click",function(){

                let comment = $("#comments").val();
                $.ajax({
                    url:'{{route('addComment')}}',
                    data:{
                        guestId : guestId,
                        comments : comment
                    },
                    success:function(data){
                        viewcommnts(guestId);
                        $('#comments').val('');
                    }
                });
            });

            $("#close-button-for-comment,#close-button-cash-out-modal, #close-button-cash-in-modal").on("click", function(){
                location.reload();
            });

            function viewcommnts(guestid){
                $.ajax({
                    url:'{{route('viewComment')}}',
                    data:{
                        guestId : guestid
                    },
                    success:function(data){
                        console.log(data);
                        let comm = "";
                        $.each(data, function(index, comment) {
                            comm += '<div class="card px-3 py-2 shadow my-2" ><div class="row"><div class="col-md-10">' + comment.comment + '</div><div class="col-md-2"><button id="'+comment.id+'" class="btn btn-danger btn-sm delete-comments"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Comment"><span class="text"><i class="fa-solid fa-trash"></i></span></button></div></div></div>';
                        });
                        $('#list-comment-all').html(comm);
                    }
                });
            }

            $(document).on('click', '.delete-comments', function(){
                let commentId = $(this).attr('id');
                console.log(commentId);
                $.ajax({
                    url:'{{route('deleteComment')}}',
                    data:{
                        commentID : commentId
                    },
                    success:function(data){
                        if(data){
                            viewcommnts(guestId);
                        }
                        
                    }
                });
            });


            // Archive Functionality ---------------
            let guestIdArchive, checkOutDate;

            $(".btn-for-archive-guest").on('click', function(){
                guestIdArchive = $(this).attr('id');
            });

            $("#archive_guest").on('click', function(){
                checkOutDate = $("#checkoutdate").val();
                $.ajax({
                    url:"{{route('archiveGuest')}}",
                    data:{
                        guestId : guestIdArchive,
                        checkOutDate: checkOutDate
                    },
                    success:function(data){
                        location.reload();
                    }
                });
            });

            $(".btn-unarchived-guest").on("click", function(){
                guestIdArchive = $(this).attr("id");
                $.ajax({
                    url:"{{route('archiveGuest')}}",
                    data:{
                        guestId : guestIdArchive,
                    },
                    success:function(data){
                        location.reload();
                    }
                });
            });


            // Cashout Functionality------------
            $("#cash-out-btn").on("click", function(){
                var selectedOption = $("input[name='cash_out_reason']:checked").val();
                let money_by_out = $("#money_by_out").val();
                if (selectedOption === "gust") {
                    let type = "guest";
                    let guestCode = $("#guest-code").val();
                    let guestAmount = $("#guest-amount").val();
                    $.ajax({
                        url:"{{route('cashRegisterOutFlow')}}",
                        data:{
                            type:type,
                            money_by: money_by_out,
                            guestCode:guestCode,
                            guestAmount:guestAmount,
                        },
                        success:function(data){
                            location.reload();
                        }
                    });
                } else if (selectedOption === "other") {
                    let type = "other";
                    let otherComments = $("#other-cash-out-comments").val();
                    let otherAmount = $("#other-amount").val();
                    $.ajax({
                        url:"{{route('cashRegisterOutFlow')}}",
                        data:{
                            type:type,
                            money_by: money_by_out,
                            otherComments:otherComments,
                            otherAmount : otherAmount,
                        },
                        success:function(data){
                            location.reload();
                        }
                    });
                }
            });


            // Cashin Functionality------------
            $("#cash-in-btn").on("click", function(){
                var selectedOption = $("input[name='cash_in_reason']:checked").val();
                let money_by_in = $("#money_by_in").val();
                if (selectedOption === "gust") {
                    let type = "guest-in";
                    
                    let guestCode = $("#guest-in-code").val();
                    let guestAmount = $("#guest-in-amount").val();
                    $.ajax({
                        url:"{{route('cashRegisterOutFlow')}}",
                        data:{
                            type:type,
                            money_by: money_by_in,
                            guestCode:guestCode,
                            guestAmount:guestAmount,
                        },
                        success:function(data){
                            location.reload();
                        }
                    });
                } else if (selectedOption === "other") {
                    let type = "other-in";
                    let otherComments = $("#other-cash-in-comments").val();
                    let otherAmount = $("#other-in-amount").val();
                    $.ajax({
                        url:"{{route('cashRegisterOutFlow')}}",
                        data:{
                            type:type,
                            money_by: money_by_in,
                            otherComments:otherComments,
                            otherAmount : otherAmount,
                        },
                        success:function(data){
                            location.reload();
                        }
                    });
                }
            });

        });
    </script>

</body>

</html>