<script type="text/javascript" src="{{ url('/') }}/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{{ url('/') }}/js/materialize.min.js"></script>
<script>
	$('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true, // Displays dropdown below the button
      @if(session('dir') == 'ltr')
        alignment: 'left',
      @else
        alignment: 'right',
      @endif
       // Displays dropdown with edge aligned to the left of button
      stopPropagation: false // Stops event propagation
    }
  );
</script>