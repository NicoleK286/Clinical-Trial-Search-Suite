<!DOCTYPE html>
<html>
<head>
<style type='text/css'>
	body {
			background-image: url('searchbcg.png'); 
			background-repeat: y-repeat;
	}

	.search_crit{
			display: none;
	}
	
	.start_open{
			display: block;
	}
	#search{
			width: 80%;
			float: right;
	}
	#form_portion{
			width: 20%;
			float: left;
	}
	.filter_category{
			background: #1f1881;
			border-radius: 10px;
			border: 1px solid black;
			background-clip: content-box;
			color: white;
	}
</style>
<link rel="stylesheet" type="text/css" href="../css/search_stylesheet.css">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<?php
	$title = 'Trial Search';
	include_once '../inc/header.inc.php';
	if (!isset($_SESSION['uid'])){
		header("location: homepage.php");
	}

?>
<?php
	include '../inc/sql_connect.php';
	$treatments = 'SELECT TREATMENT_NAME, MODE_OF_ACTION FROM TREATMENTS';
	$institutes = 'SELECT INS_CITY, INS_STATE_REGION FROM INSTITUTIONS';
	$sites = 'SELECT SITE_CITY, SITE_STATE FROM SITES';
	//insert and remove duplicates, easier work and less memory used

	$treat_name = array();
	$treat_mode = array();
	$city = array();
	$state = array();

	$result_1 = mysqli_query($conn, $treatments);
	while($row = mysqli_fetch_assoc($result_1)){
		$treat_name[] = $row['TREATMENT_NAME'];
		$treat_mode[] = $row['MODE_OF_ACTION'];
	}
	$result_2 = mysqli_query($conn, $institutes);
	while($row = mysqli_fetch_assoc($result_2)){
		$city[] = $row['INS_CITY'];
		$state[] = $row['INS_STATE_REGION'];
	}
	$result_3 = mysqli_query($conn, $sites);
	while($row = mysqli_fetch_assoc($result_3)){
		$city[] = $row['SITE_CITY'];
		$state[] = $row['SITE_STATE'];
	}
	$treat_name = array_values(array_unique($treat_name));
	$treat_mode = array_values(array_unique($treat_mode));
	$city = array_values(array_unique($city));
	$state = array_values(array_unique($state));
	mysqli_close($conn);

?>
<body>
<div class="container-fluid">
<div class="row">
	<div class="col" style="margin:0px; padding: 0px;">
		<div class="card" style = "width: 20rem; border: 8px solid ; ">
			<div class = "card-body" id="search_form">
				<div id='form_portion' class="form_card">
				<form name='SearchForm' id='s_form' method='post'>
				<fieldset>
				<legend>Filter Search</legend>
				<input type='submit' name='submit' value='Search' id="submit_btn">
				<input type='reset' name='reset' value='Reset'><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle ="collapse" data-bs-target = "#trial_info">TRIAL DETAILS</div>
				<div class='search_crit start_open'>
				<div id="trial_info" class="collapse">

				<label for='t_id'>Trial ID:</label><br>
				<input type='text' id='t_id' name='t_id'><br>

				<label for='t_name'>Trial Name:</label><br>
				<input type='text' id='t_name' name='t_name'><br>
						
				<label for='t_start'>Trial Start:</label><br>
				<input type='date' id='t_start' name='t_start'><br>
				<label for='t_end'>Trial End:</label><br>
				<input type='date' id='t_end' name='t_end'><br>
					
				<label for='t_rstart'>Recruitment Start:</label><br>
				<input type='date' id='t_rstart' name='t_rstart'><br>
				<label for='t_rend'>Recruitment End:</label><br>
				<input type='date' id='t_rend', name='t_rend'><br>
					
				<label for='t_status'>Trial Status</label><br>
				<select id='t_status' name='t_status'>
					<option value=''>---</option>
					<option value='no information'>No Information</option>
					<option value='completed'>Completed</option>
					<option value='terminated'>Terminated</option>
					<option value='withdrawn'>Withdrawn</option>
					<option value='recruiting'>Recruiting</option>
					<option value='not yet recruiting'>Not Yet Recruiting</option>
					<option value='active not recruiting'>Active, not Recruiting</option>
				</select><br>
				<label for='t_phase'>Trial Phase</label><br>
				<select id='t_phase' name='t_phase'>
					<option value=''>---</option>
					<option value='unknown phase'>Unknown</option>
					<option value='phase 1'>Phase 1</option>
					<option value='phase 2'>Phase 2</option>
					<option value='phase 3'>Phase 3</option>
					<option value='phase 1/2'>Phase 1/2</option>
					<option value='phase 2/3'>Phase 2/3</option>
				</select></br>

				<label for='t_country'>Country</label><br>
				<select id='t_country' name='t_country'>
					<option value=''>---</option>
					<?php
						$countries = fopen('../inc/countries.txt', 'r') or die();
						while(!feof($countries)){
							$country = fgets($countries);
							echo "<option value='" . str_replace("\n", '',$country) . 
								"'>" . $country . "</option>";
						}
						fclose($countries);
					?>
				</select><br>
				</div>
				</div>
				</div><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle = "collapse" data-bs-target = "#treatment_info">TREATMENT</div>
				<div class='search_crit start_open'>
				<div class="collapse" id="treatment_info">
				<label for='tr_name'>Treatment Name</label><br>
				<input type='text' id='tr_name' name='tr_name'><br>
				<label for='tr_mode'>Treatment Mode Action</label><br>
				<input type='text' id='tr_mode' name='tr_mode'><br>
				<label for='tr_mole'>Small Molecule?</label><br>
				<select id='tr_mole' name='tr_mole'>
					<option value=''>---</option>
					<option value='&#61;'>Yes</option>
					<option value='&#60;&#62;'>No</option>
				</select><br>
				</div>
				</div>
				</div><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle ="collapse" data-bs-target ="#institution_info">PARTICIPATING INSTITUTIONS</div>
				<div class='search_crit start_open'>
				<div class="collapse" id="institution_info">
				<label for ='i_name'>Institute Name</label><br>
				<input type='text' id='i_name' name='i_name'><br>
				<label for='i_country'>Country</label><br>
				<select id='i_country' name='i_country'>
					<option value=''>---</option>
					<?php
						$countries = fopen('../inc/countries.txt', 'r') or die();
						while(!feof($countries)){
							$country = fgets($countries);
							echo "<option value='" . str_replace("\n", '',$country) . 
								"'>" . $country . "</option>";
						}
						fclose($countries);
					?>
				</select><br>
				<label for='i_state'>State</label><br>
				<input type='text' id='i_state' class='state' name='i_state'><br>
				<label for='i_city'>City</label><br>
				<input type='text' id='i_city' class='city' name='i_city'><br>
				<label for='i_spon_collab'>Sponsor or Collaborator?</label><br>
				<select id='i_spon_collab' name = 'i_spon_collab'>
					<option value='TRIAL_INS'>---</option>
					<option value='TRIAL_COLLABORATORS'>Collaborator</option>
					<option value='TRIAL_LEADSPONSORS'>Lead Sponsor</option>
				</select><br>
				</div>
				</div>
				</div><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle ="collapse" data-bs-target = "#mesh_info">MESH TERMS</div>
				<div class = 'search_crit start_open'>
				<div id="mesh_info" class="collapse">
				<label for='m_name'>Mesh Term</label><br>
				<input type='text' id='m_name' name='m_name'><br>
				<label for='m_dis'>Indication</label><br>
				<input type='text' id='m_dis' name='m_dis'><br>
				<label for='m_cancer'>Cancer Stage</label><br>
				<select id='m_cancer' name='m_cancer'>
					<option value=''>---</option>
					<option value='stage I'>Stage I</option>
					<option value='stage II'>Stage 	II</option>
					<option value='stage III'>Stage III</option>
					<option value='stage IV'>Stage IV</option>
				</select><br>
				</div>
				</div>
				</div><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle = "collapse" data-bs-target = "#publication_info">PUBLICATIONS</div>
				<div class='search_crit start_open'>
				<div id = "publication_info" class="collapse">

				<label for='p_auth'>Author</label><br>
				<input type='text' id='p_auth' name='p_auth'><br>
				<label for='p_jour'>Journal Name</label><br>
				<input type='text' id='p_jour' name='p_jour'><br>
				<label for='p_tit'>Publication Title</label><br>
				<input type='text' id='p_tit' name='p_tit'><br>
				</div>
				</div>
				</div><br>
					
				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle = "collapse" data-bs-target ="#sites_info">TRIAL SITES</div>
				<div class='search_crit start_open'>
				<div id ="sites_info" class="collapse">
				<label for='s_name'>Name</label><br>
				<input type='text' id='s_name' name='s_name'><br>
				<label for='s_country'>Country</label><br>
				<select id='s_country' name='s_country'>
					<option value=''>---</option>
					<?php
						$countries = fopen('../inc/countries.txt', 'r') or die();
						while(!feof($countries)){
							$country = fgets($countries);
							echo "<option value='" . str_replace("\n", '',$country) . 
								"'>" . $country . "</option>";
						}
						fclose($countries);
					?>
				</select><br>
				<label for='s_state'>State</label><br>
				<input type='text' id='s_state' class='state' name='s_state'><br>
				<label for='s_city'>City</label><br>
				<input type='text' id='s_city' class='city' name='s_city'><br>
				</div>
				</div>
				</div><br>

				<div class='filter_tab'>
				<div class='filter_category' data-bs-toggle = "collapse" data-bs-target ="#hcp_info">HEALTHCARE PERSONNEL (HCP)</div>
				<div class='search_crit start_open'>
				<div id = "hcp_info" class="collapse">
				<label for='h_name'>Name</label><br>
				<input type='text' id='h_name' name='h_name'><br>
				<label for='h_cred'>Credentials</label><br>
				<select id='h_cred' name='h_cred'>
					<option value=''>---</option>
					<option value='MD'>MD</option>
					<option value='Prof.'>Prof.</option>
					<option value='MD PhD'>MD PhD</option>
					<option value='PhD'>PhD</option>
					<option value='Professor Dr'>Professor Dr</option>
					<option value='Professor MD'>Professor MD</option>
					<option value='Dr.'>Dr.</option>
					<option value='MBBch PhD'>MBBch PhD</option>
					<option value='MBBS MD'>MBBS MD</option>
				</select><br>
				<label for='h_inv'>Investigator?</label><br>
				<select id='h_inv' name='h_inv'>
					<option value=''>---</option>
					<option value='&#61;'>Yes</option>
					<option value='&#60;&#62;'>No</option>
				</select><br>
				<label for='h_col'>Collaborator?</label><br>
				<select id='h_col' name='h_col'>
					<option value=''>---</option>
					<option value='&#61;'>Yes</option>
					<option value='&#60;&#62;'>No</option>
				</select>
				</div>
				</div>
				</div>
				</fieldset>
				</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col" style="margin: 0px; padding: 0px;">
		<div class="card" style ="border: 8px solid; width: 1000px; height: 800px;">
			<div class="card-body" id="results_card">
				<div id = 'search' class="overflow-auto">
					<script>
					$(document).ready(function () {
					$("#s_form").submit(function (e) {
					        	var result = true;
					        	if (result == true) {
					            	$.ajax({
					                		type: "POST",
					                		url: "ProjectSearch_2.php",
					                		data: $(this).serialize(),
					                		success: function (msg) {
					                        		$("#search").html(msg);
					                		},
									error: function (req, status, error) {
					                    		alert(req + " " + status + " " + error);
					                		}
					            	});
					        	}
					        	return false;
					    });
					});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script>
	$(function() {
		var treat_name = <?php echo json_encode($treat_name); ?>;
		var treat_mode = <?php echo json_encode($treat_mode); ?>;
		var state = <?php echo json_encode($state); ?>;
		var city = <?php echo json_encode($city); ?>; 
		$( "#tr_name" ).autocomplete({
               		minLength:2,   
               		delay:200,   
              		source: treat_name
        	});
		$( "#tr_mode" ).autocomplete({
               		minLength:2,   
               		delay:200,   
               		source: treat_mode
        	});
		$( ".state" ).autocomplete({
               		minLength:2,   
               		delay:200,   
               		source: state
        	});
		$( ".city" ).autocomplete({
               		minLength:2,   
               		delay:200,   
               		source: city
        	});
});
</script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>