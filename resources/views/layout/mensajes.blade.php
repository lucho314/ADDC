@if(session()->has('success'))
	<script type="text/javascript">
		toastr.success("{{ session('success') }}")
	</script>
@elseif(session()->has('error'))
	<script type="text/javascript">
		toastr.error("{{ session('error') }}")
	</script>
@elseif (session()->has('warning'))
	<script type="text/javascript">
		toastr.success("Esto es una adverencia")
	</script>
@endif