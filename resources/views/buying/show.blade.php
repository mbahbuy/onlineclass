@extends('dashboard.app')

@section('styles')
    
@endsection

@section('content')    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="page-pretitle">
                        Live
                    </div>
                    <h1 class="page-title">
                        Kelas - {{ $bimbel->title }}
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <content class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="align-middle text-center">Anda telah masuk dikelas - {{ $bimbel->title }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </content>
    <!-- content -->

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('script')
<script>

const dayStart = {{ $bimbel->day_start }};
const dayEnd = {{ $bimbel->day_end }};
const timeStart = "{{ $bimbel->time_start }}";
const timeEnd = "{{ $bimbel->time_end }}";

$(function () {
    if (isWithinSchedule(dayStart, dayEnd, timeStart, timeEnd)) {
        console.log("The current time is within the specified schedule.");
    } else {
        console.log("The current time is outside the specified schedule.");
        window.location = "{{ route('kelas') }}";
    }
});


function isWithinSchedule(dayStart, dayEnd, timeStart, timeEnd) {
    const now = new Date();
    const currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
    const currentTime = now.getHours() * 60 + now.getMinutes(); // Convert time to minutes for easier comparison

    // Convert timeStart and timeEnd to minutes
    const [startHr, startMn] = timeStart.split(':').map(Number);
    const [endHr, endMn] = timeEnd.split(':').map(Number);
    const startTimeInMinutes = startHr * 60 + startMn;
    const endTimeInMinutes = endHr * 60 + endMn;

    // Check if the current day is within the dayStart and dayEnd range
    const isWithinDayRange = (dayStart <= currentDay && currentDay <= dayEnd) ||
                             (dayEnd < dayStart && (currentDay >= dayStart || currentDay <= dayEnd)); // Handle week overlap (e.g., Friday to Monday)

    // Check if the current time is within the timeStart and timeEnd range
    const isWithinTimeRange = startTimeInMinutes <= currentTime && currentTime <= endTimeInMinutes;

    // Return true if both conditions are met
    return isWithinDayRange && isWithinTimeRange;
}

</script>
@endsection