<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Panel heading</div>
  <div class="panel-body">
    <p>...</p>
  </div>
  <ul class="list-group">
    <li class="list-group-item"><b style="color:red">1</b> - Not Confident</li>
    <li class="list-group-item"><b style="color:red">2</b> - Confident</li>
    <li class="list-group-item"><b style="color:red">3</b> - Slightly Confident</li>
    <li class="list-group-item"><b style="color:red">4</b> - Very Confident</li>
  </ul>
  <!-- Table -->
  <table class="table table-striped">
    ...
  </table>
  <div class="panel-footer">Panel footer</div>
</div>

style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });
</script>

col-md-offset-5

$uid = $this->login_model->getuid($this->session->userdata('username'));