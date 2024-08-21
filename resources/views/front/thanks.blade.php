@extends('front.layouts.app')
@section('content')

@endsection

@section('customJs')
<script>
    Swal.fire({
        icon: 'success',
        title: 'Your Order has been added successfully!',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Close',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{route('front.home')}}'; 
        }
    });
</script>

@endsection