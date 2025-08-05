@extends('_main_layout')

@section('content')
{{--<style>--}}
{{--    .toolbar {--}}
{{--        float:left;--}}
{{--    }--}}
{{--    table.dataTable tbody tr:hover {--}}
{{--        background: yellow;--}}
{{--    }--}}
{{--</style>--}}
<script type="text/javascript">
    $(document).ready(function() {
        // $("#description").wysiwyg();
        $(document).on("click", ".open-reqModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val(id);
            if(id > 0){
                $.ajax({
                    url: '{{ route('hrd.recruitment.getVacan') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        var txt = data['description'];
                        $('#name').val(data['name']);
                        $('#job_title_code').val(data['job_title_code']);
                        $('#dept_id').val(data['dept_id']);
                        $('#location_id').val(data['location_id']);
                        $('#no_of_positions').val(data['no_of_positions']);
                        $('.editor-content').append(txt);
                        // $('#description').val(txt);
                    }
                });
            }else{
                $('#name').val('');
                $('#job_title_code').val('0');
                $('#dept_id').val('0');
                $('#location_id').val('0');
                $('#no_of_positions').val('');
                $('.editor-content').attr('name', 'description')
            }
        });
        var table = $('#reqTable').DataTable({
            dom: 'l<"toolbar">frtip',
            initComplete: function(){
                $("div.toolbar")
                    .html('<a class="btn btn-primary" href="{{ route('hrd.recruitment.create') }}"><i class="fa fa-plus"></i> New Vancancy</a>');
            }
        });
        // $('#reqTable').on('click', 'tbody tr', function () {
        //     // alert( 'You clicked on 1' );
        //     var data = table.row( $(this) ).data();
        //     var id = $(data[5]).attr("data-id"); // get attribute data-id from TD
        //     console.log(id);
        //     window.location = "/hrd/recruitment/"+id+"/show";
        // } );
    });
</script>
<div class="container">
    <h2>Recruitment</h2>
    <div style="margin-bottom: 20px;"></div>
    <div class="row">
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="data-table-list">
            <div class="table-responsive">
            <?php $no = 1;?>
            <table id="reqTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Job Title</th>
                    <th>Job Level</th>
                    <th>Location</th>
                    <th>No of Position</th>
                    <th>View Candidate</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($jobVacan as $vacan)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $vacan->name }}</td>
                        <td>{{ $vacan->job_title->job_title }}</td>
                        <td>{{ $vacan->job_location->name }}</td>
                        <td>{{ $vacan->no_of_positions }}</td>
                        <td><a href='{{ route('hrd.recruitment.show', $vacan->id) }}'><i class='fa fa-eye'></i></a></td>
{{--                        @if($vacan->vacancy_status > '1')--}}
{{--                        <td><a id="show" href="{{ route('hrd.vPersonal',$vacan->id) }}" ><i class="fa fa-eye"></i></a></td>--}}
{{--                        @else--}}
                        <td><a href='{{ route('hrd.recruitment.edit', $vacan->id) }}'><i class='fa fa-edit'></i></a></td>
{{--                        @endif--}}
                    </tr>
                    <?php $no++;?>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</div>
<div id="reqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal">Request Vacancy</h4>
            </div>
        </div>
    </div>
</div>
@endsection