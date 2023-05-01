<!DOCTYPE html>
<html>
<head>
<style type='text/css'>
	body {
  	   	background-image: url('../main/image_fittedv2.jpg'); 
   		background-repeat: y-repeat;
	}
	.search_crit{
			display: none;
	}
	.filter_category{
		background: #6677d6;
		color: white;
		border-radius: 10px;
		border: 1px solid black;
		background-clip: content-box;
		width: 300px;
	}
</style>
<link rel="stylesheet" type="text/css" href="../css/trial_style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
rel="stylesheet" 
integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
crossorigin="anonymous">

<?php
	$title = 'Trial Search';
	include_once '../inc/header.inc.php';
	if (!isset($_SESSION['uid'])){
		header("location: homepage.php");
	}
?>
<div class="container-fluid">
<?php
	include '../inc/sql_connect.php';
	$stmt = mysqli_stmt_init($conn);
	$page_content = '';
	
	$page_content .= "<div class='filter_tab'><div class='filter_category'>Trial</div>".
		"<div class='search_crit' id='trial'>";

	
	$search_1 = 'SELECT * FROM TRIAL_SUMMARY JOIN TRIAL_PHASE USING (TRIAL_ID) ' .
	          'JOIN TRIAL_STUDY_DETAILS USING (TRIAL_ID) JOIN TRIAL_PATIENT_ENROLL ' .
	          'USING (TRIAL_ID) WHERE TRIAL_ID = ?';
	$search_2 = 'SELECT * FROM TRIAL_CTRY_ENROLL WHERE TRIAL_ID = ?';

	
	if(!mysqli_stmt_prepare($stmt, $search_1)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else{
			$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
			$result = mysqli_stmt_get_result($stmt);
			$page_content .= "<tr><th>Trial ID</th><th>Alternate ID</th><th>URL Link</th><th>Trial Name</th><th>Trial Phase</th><th>Trial Status</th><th>Recruitment Period</th><th>Recruitment End Estimated</th><th>Study Period Period</th><th>Trial Main Completion Data</th><th>Trial Latest Result</th><th>Trial End Estimated</th><th>Patient per-Site-per-Month (estimated)</th><th>Patients per Site per Month</th><th>Patient Age Range</th><th>Total Trial Participants</th><th>Total Number of Sites</th><th>Participant Numbers by Country</th></tr>";

			while ($row = mysqli_fetch_assoc($result)) {
				$page_content .= '<tr><td>' . $row['TRIAL_ID'] . '</td><td><ul>'; 
				foreach(explode(", ", $row['TRIAL_ALT_ID']) as $alt){
					$page_content .= '<li>'. $alt . '</li>';
				}
			    $page_content .= '</ul></td>'
        	.'<td><a href="' . $row['TRIAL_URL'] . '">' . $row['TRIAL_URL'] . '</a></td>'
        	.'<td>' . $row['TRIAL_NAME'] . '</td>'
        	.'<td>' . $row['TRIAL_PHASE'] . '</td>'
        	.'<td>' . $row['TRIAL_STATUS'] . '</td>'
        	.'<td><ul><li>Start: ' . $row['TRIAL_RECRUITMENT_START'] . '</li><li>End: ' 
            . $row['TRIAL_RECRUITMENT_END'] . '</li></ul></td>'
        	.'<td>' . $row['TRIAL_RECRUITMENT_END_ESTIMATED'] . '</td>'
        	.'<td><ul><li>Start: ' . $row['TRIAL_STUDY_START'] . '</li><li>End: ' 
            . $row['TRIAL_STUDY_END'] . '</li></ul></td>'
        	.'<td>' . $row['TRIAL_PRIMARY_COMPLETION_DATE'] . '</td>'
        	.'<td>' . $row['TRIAL_RESULT_SINCE'] . '</td>'
        	.'<td>' . $row['TRIAL_STUDY_END_ESTIMATED'] .'</td>'
        	.'<td>' . $row['TRIAL_PATIENT_PER_SITE_PER_MONTH_ESTIMATED'] . '</td>'
        	.'<td>' . $row['TRIAL_PATIENT_PER_SITE_PER_MONTH'] . '</td>'
        	.'<td>' . $row['TRIALPTN_AGE_RANGE'] . '</td>';
	}
}
}

	if(!mysqli_stmt_prepare($stmt, $search_2)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else {
			$result = mysqli_stmt_get_result($stmt);
			$ctry_num = array('ctry' => array(), 'c_num' => array());
			while($row = mysqli_fetch_assoc($result)){
				$ctry_total_num = $row['TRIALCTR_TOTAL_ENROLLMENT'];
				$ctry_sites_num = $row['TRIALCTR_NR_SITES'];
				$cntry_num['ctry'][] = $row['TRIAL_COUNTRY_ENROLLMENT'];
				$cntry_num['c_num'][] = $row['TRIAL_COUNTRY_ENROLL_NO'];
			}
			$page_content .= '<td>' . $ctry_total_num . '</td>'
				. '<td>' . $ctry_sites_num  . '</td>'
				. '<td><ul>';  
			for($var = 0; $var < count($cntry_num['ctry']); $var++){ 
				$page_content .= '<li>' . $cntry_num['ctry'][$var] . ': ' .
					$cntry_num['c_num'][$var] . '</li>';
			}
			$page_content .= '<li>Other: ' .
				($ctry_total_num - array_sum($cntry_num['c_num'])) .
				'</li></ul></td></tr>';  
		}
	}
	$page_content .= "</table></div></div></div>";


	
	$page_content .= "<div class='filter_tab'>".
		"<div class='filter_category'>Treatment</div>".
		"<div class='search_crit' id='treat'>";

	$search_1 = 'SELECT * FROM TRIAL_TREATMENT INNER JOIN TREATMENTS USING (TRT_ID)' .
			' WHERE TRIAL_ID = ?';
	
	if(!mysqli_stmt_prepare($stmt, $search_1)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else{
			$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
			$result = mysqli_stmt_get_result($stmt);
			$i = 1;
			$page_content .= '<tr><th>Treatment Name</th><th>Mode of Action</th><th>Small Molecule</th><th>Therapeutic Protein</th></tr>';
			while($row = mysqli_fetch_assoc($result)){
				$page_content .= '<tr><td>' . $row['TREATMENT_NAME'] . '</td><td>' .
					$row['MODE_OF_ACTION'] . '</td><td>' . 
					$row['SMALL_MOLECULE'] . '</td><td>' .
					$row['THERAPEUTIC_PROTEIN'] . '</td></tr>';
				$i++;
				}
		}
	}
	$page_content .= "</table></div></div></div>";



	$page_content .= "<div class='filter_tab'>" .
		"<div class='filter_category'>Mesh Terms</div>" .
		"<div class='search_crit' id='mesh'>";

	$search_1 = 'SELECT * FROM TRIAL_MESH INNER JOIN MESH_TERMS USING (MESH_ID)' .
			' WHERE TRIAL_ID = ?';
	
	if(!mysqli_stmt_prepare($stmt, $search_1)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else{
			$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
			$result = mysqli_stmt_get_result($stmt);
			$i = 1;
			$page_content .= '<tr><th>Mesh Term</th><th>Disease Type</th><th>Cancer Stage</th><th>Treatments</th><th>Tumor Classification</th></tr>';
			while($row = mysqli_fetch_assoc($result)){
				$page_content .= '<tr><td> ' . $row['MESH_TERM'] . '</td><td>' .
					$row['DISEASE_TYPE'] . '</td><td>' .
					$row['CANCER_STAGE'] . '</td><td>' .
					$row['TREATMENTS'] . '</td><td>' .
					$row['TUMOR_CLASSIFICATION'] . '</td></tr>' ;
				$i++;
			}
		}
	}
	$page_content .= "</table></div></div></div>";


	

	$page_content .= "<div class='filter_tab'>" .
		"<div class='filter_category'>Institute</div>" .
		"<div class='search_crit' id='institute'>";


	// Define and initialize $stmt and $conn variables here
	
	$search_1 = 'SELECT * FROM TRIAL_LEADSPONSORS INNER JOIN INSTITUTIONS ' .
		'USING (INS_ID) WHERE TRIAL_ID = ?';
	$search_2 = 'SELECT * FROM TRIAL_COLLABORATORS INNER JOIN INSTITUTIONS ' .
		'USING (INS_ID) WHERE TRIAL_ID = ?';
	
	$questions = array($search_1, $search_2);
	foreach ($questions as $q){
		$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
		if(!mysqli_stmt_prepare($stmt, $q)){
			echo 'We are sorry, something went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		} else {
			mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
			if(!mysqli_stmt_execute($stmt)){
				echo 'Something else went wrong<br><br>';
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				die();
			}else{
				$result = mysqli_stmt_get_result($stmt);
				if(strpos($q, 'LEADSPONSOR')){
					$page_content .= '<tr><th>' .
						'Leadsponsor Institute' .
						'</th></tr>';
				} else {
					$page_content .= '<tr><th>' .
						'Collaborator Institute' .
						'</th></tr>';		
				}
				$page_content .= '<tr><th>Institute Name</th><th>Street Address</th><th>Country</th><th>City</th><th>State/Region</th><th>ZipCode</th></tr>';
				while($row = mysqli_fetch_assoc($result)){
					$page_content .= '<tr><td>' . $row['INSTITUTION_NAME'] . '</td><td>' .
						$row['INS_STREET_ADDRESS'] . '</td><td>' .
						$row['INS_COUNTRY'] . '</td><td>' .
						$row['INS_CITY'] . '</td><td>' .
						$row['INS_STATE_REGION'] . '</td><td>' .
						$row['INS_ZIPCODE'] . '</td></tr>';
				}
			}
		}
		$page_content .= "</table></div>";
	}
	$page_content .= "</div></div>";
	

	$page_content .= "<div class='filter_tab'>" .
		"<div class='filter_category'>Sites</div>" .
		"<div class='search_crit' id='sites'>";



	$search_1 = 'SELECT * FROM TRIAL_SITE INNER JOIN SITES ' .
			'USING (SITE_ID) WHERE TRIAL_ID = ?';
	$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
	if(!mysqli_stmt_prepare($stmt, $search_1)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else{			
			$page_content .= '<tr><th>Site Name</th><th>Country</th><th>City</th><th>State/Region</th><th>ZipCode</th></tr>';
			
			$result = mysqli_stmt_get_result($stmt);
			$i = 1;
			while($row = mysqli_fetch_assoc($result)){
				$page_content .= '<tr><td> ' . $row['SITE_NAME'] . '</td><td>' .
				$row['SITE_COUNTRY'] . '</td><td>' .
				$row['SITE_CITY'] . '</td><td>' .
				$row['SITE_STATE_REGION'] . '</td><td>' .
				$row['SITE_ZIPCODE'] . '</td></tr>' ;
			$i++;
		}
		}
	}
	$page_content .= '</table></div></div></div>';



	$page_content .= "<div class='filter_tab'>" .
		"<div class='filter_category'>Health Care Provider</div>" .
		"<div class='search_crit' id='hcp'>";


	$search_1 = 'SELECT * FROM TRIAL_HCP INNER JOIN HCP ' .
			'USING (HCP_ID) WHERE TRIAL_ID = ?';
	$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
	if(!mysqli_stmt_prepare($stmt, $search_1)){
		echo 'We are sorry, something went wrong<br><br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		die();
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
		if(!mysqli_stmt_execute($stmt)){
			echo 'Something else went wrong<br><br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			die();
		}else{
			$page_content .= '<tr><th>HCP Full Name</th><th>Credentials</th><th>Phone Number</th><th>Email</th><th>Principal Investigator</th><th>Collaborator</th></tr>';
			$result = mysqli_stmt_get_result($stmt);
			$i = 1;
			while($row = mysqli_fetch_assoc($result)){
				$page_content .= '<tr><td> ' . $row['HCP_FULL_NAME'] . '</td><td>' .
					$row['HCP_CREDENTIALS'] . '</td><td>' .
					$row['HCP_PHONENO'] . '</td><td>' .
					$row['HCP_EMAIL'] . '</td><td>' .
					$row['HCP_IS_PRINCIPAL_INVESTIGATOR'] . '</td><td>' .
					$row['HCP_IS_COLLABORATOR'] . '</td></tr>' ;
				$i++;
			}
		}
	}
	$page_content .= '</table></div></div></div>';



	$page_content .= "<div class='filter_tab'>" .
    "<div class='filter_category'>Publications</div>" .
    "<div class='search_crit' id='publication'>";
    
	$search_1 = 'SELECT * FROM TRIAL_PUB INNER JOIN PUBLICATION ' .
        'USING (PUB_ID) WHERE TRIAL_ID = ?';
	$page_content .= "<div class='table-responsive'><table class='table table-bordered table-striped'>";
	if(!mysqli_stmt_prepare($stmt, $search_1)){
    	echo 'We are sorry, something went wrong<br><br>';
    	mysqli_stmt_close($stmt);
    	mysqli_close($conn);
    	die();
	} else {
    	mysqli_stmt_bind_param($stmt, 's', $_GET['id']);
    	if(!mysqli_stmt_execute($stmt)){
        	echo 'Something else went wrong<br><br>';
        	mysqli_stmt_close($stmt);
        	mysqli_close($conn);
        	die();
    }else{
        $page_content .= '<tr><th>Publication Title</th><th style="padding-left: 10px;">Authors</th><th>Journal</th><th>Citation</th><th>PubMed Id</th><th>ISSN Reference</th></tr>';
        $result = mysqli_stmt_get_result($stmt);
        $i = 1;
        while($row = mysqli_fetch_assoc($result)){

            $page_content .= '<tr><td>' . $row['PUB_TITLE'] . '</td> <td>';
            foreach(explode(", ", $row['PUB_AUTHORS']) as $alt){
                $page_content .= '<ul>'. $alt. '</ul>';
            }
            $page_content .= '</td><td>' .
                $row['PUB_JOURNAL'] . '</td><td>' .
                $row['PUB_CITE'] . '</td><td>' .
                $row['PUB_PMID'] . '</td><td>' .
                $row['PUB_JRNL_ISSN'] . '</td></tr>';
            $i++;
        }
        $page_content .= '</table></div></div></div>';
    }
}



	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	echo $page_content;
?>
<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
<script>
$(document).ready(function () {
	$('.filter_category').on('click', function() {
   		$(this).closest('.filter_tab').find('.search_crit').slideToggle();
  	});
	var url = window.location.href.slice(window.location.href.indexOf('section='));
	function GetParameterValues() {
		var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 1; i < url.length; i++) {
			var urlparam = url[i].split('=');
			return urlparam[1];
		}
	}
	console.log(GetParameterValues());
	$('#' + GetParameterValues()).slideToggle();
});
</script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>