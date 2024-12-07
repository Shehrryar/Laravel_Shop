@extends('admin.layout.app')
@section('content') 
<!-- Content Header (Page header) -->

<!-- Main content -->
@endsection
@section('customjs') 


<script type="module" src="{{ asset('js/app.js') }}"></script>

<script>



console.log(Echo);


Echo.channel('trades').listen('newTrae', (e)=>{
    console.log(e.trade);
    
});    
</script>
@endsection