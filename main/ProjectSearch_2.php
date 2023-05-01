<?php
	include '../inc/sql_connect.php';
	$stmt = mysqli_stmt_init($conn);


	$joins = '';
	$total_dt = '';
	$total_query = array();
	$total_param = array();
	$page_content = '';
	
	//trial
	if(!empty($_POST['t_id'])){
		$total_query[] = 'LOWER(TRIAL_SUMMARY.TRIAL_ID) LIKE ?';
		$total_param[] = '%' . strtolower($_POST['t_id']) . '%';
		$total_dt .= 's';
    	}
	if(!empty($_POST['t_name'])){
		$total_query[] = 'LOWER(TRIAL_SUMMARY.TRIAL_NAME) LIKE ?';
		$total_param[] = '%' . strtolower($_POST['t_name']) . '%';
		$total_dt .= 's';
	}
	if(!empty($_POST['t_status'])){
		$total_query[] = 'TRIAL_SUMMARY.TRIAL_STATUS = ?';
		$total_param[] = $_POST['t_status'];
		$total_dt .= 's';
	}
	if(!empty($_POST['t_phase'])){
		$total_query[] = 'TRIAL_SUMMARY.TRIAL_PHASE = ?';
		$total_param[] = $_POST['t_phase'];
		$total_dt .= 's';
	}

	if(!empty($_POST['t_country'])){
		$joins .= ' INNER JOIN TRIAL_CTRY_ENROLL USING(TRIAL_ID)';
		$total_query[] = 'TRIAL_CTRY_ENROLL.TRIAL_COUNTRY_ENROLLMENT LIKE ?';
		$total_param[] = '%' . $_POST['t_country'] . '%';
		$total_dt .= 's';
	}
	if(!empty($_POST['t_start']) | !empty($_POST['t_end'])){
		$joins .= ' INNER JOIN TRIAL_PHASE USING(TRIAL_ID)';
		if(!empty($_POST['t_start'])){
			$total_query[] = 'STR_TO_DATE(TRIAL_STUDY_START, "%d-%M-%Y") >= ?';
			$total_param[] = $_POST['t_start'];
			$total_dt .= 's';
		}
		if(!empty($_POST['t_end'])){
			$total_query[] = 'STR_TO_DATE(TRIAL_STUDY_END, "%d-%M-%Y") <= ?';
			$total_param[] = $_POST['t_end'];
			$total_dt .= 's';
		}

	}
	if(!empty($_POST['t_rstart']) | !empty($_POST['t_rend'])){
		$joins .= ' INNER JOIN TRIAL_STUDY_DETAILS USING(TRIAL_ID)';
		if(!empty($_POST['t_rstart'])){
			$total_query[] = 'STR_TO_DATE(TRIAL_RECRUITMENT_START, "%d-%M-%Y") >= ?';
			$total_param[] = $_POST['t_rstart'];
			$total_dt .= 's';
		}
		if(!empty($_POST['t_rend'])){
			$total_query[] = 'STR_TO_DATE(TRIAL_RECRUITMENT_END, "%d-%M-%Y") <= ?';
			$total_param[] = $_POST['t_rend'];
			$total_dt .= 's';
		}

	}
	
	//institution
	if(!empty($_POST['i_name'])){
		$total_query[] = 'LOWER(INSTITUTIONS.INSTITUTION_NAME) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['i_add']) . "%";
		$total_dt .= 's';
		$institution = True;
	}

	if(!empty($_POST['i_country'])){
		$total_query[] = 'INSTITUTIONS.INS_COUNTRY LIKE ?';
		$total_param[] = '%' . $_POST['i_country'] . '%';
		$total_dt .= 's';
		$institution = True;
	}
	if(!empty($_POST['i_state'])){
		$total_query[] = 'INSTITUTIONS.INS_STATE_REGION LIKE ?';
		$total_param[] = '%' . $_POST['i_state'] . '%';
		$total_dt .= 's';
		$institution = True;
	}
	if(!empty($_POST['i_city'])){
		$total_query[] = 'INSTITUTIONS.INS_CITY LIKE ?';
		$total_param[] = '%' . $_POST['i_city'] . '%';
		$total_dt .= 's';
		$institution = True;
	}
	if(isset($institution)){
		$joins.= " INNER JOIN " . $_POST['i_spon_collab'] . 
			" USING(TRIAL_ID) ".
			"INNER JOIN INSTITUTIONS USING (INS_ID)";
	}

	//treatment
	if(!empty($_POST['tr_name'])){
		$total_query[] = 'LOWER(TREATMENTS.TREATMENT_NAME) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['tr_name']) . "%";
		$total_dt .= 's';
		$treatment = True;
	}
	if(!empty($_POST['tr_mode'])){
		$total_query[] = 'LOWER(TREATMENTS.MODE_OF_ACTION) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['tr_mode']) . "%";
		$total_dt .= 's';
		$treatment = True;
	}
	if(!empty($_POST['tr_mole'])){
		$total_query[] = 'TREATMENTS.SMALL_MOLECULE ' . $_POST['tr_mole'] . ' ?';
		$total_param[] = 'Y';
		$total_dt .='s';
		$treatment = True;
	}

	if(isset($treatment)){
		$joins.= " INNER JOIN TRIAL_TREATMENT USING(TRIAL_ID) ".
			"INNER JOIN TREATMENTS USING (TRT_ID)";
	}

	//mesh
	if(!empty($_POST['m_name'])){
		$total_query[] = 'LOWER(MESH_TERMS.MESH_TERM) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['m_name']) . "%";
		$total_dt .= 's';
		$mesh = True;
	}
	if(!empty($_POST['m_dis'])){
		$total_query[] = 'LOWER(MESH_TERMS.DISEASE_TYPE) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['m_dis']) . "%";
		$total_dt .= 's';
		$mesh = True;
	}
	if(!empty($_POST['m_cancer'])){
		$total_query[] = 'MESH_TERMS.CANCER_STAGE = ?';
		$total_param[] = $_POST['m_cancer'];
		$total_dt .= 's';
		$mesh = True;
	}
	if(isset($mesh)){
		$joins.= " INNER JOIN TRIAL_MESH USING(TRIAL_ID) ".
			"INNER JOIN MESH_TERMS USING (MESH_ID)";
	}	

	//hcp
	if(!empty($_POST['h_name'])){
		$total_query[] = 'LOWER(HCP.HCP_FULL_NAME) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['h_name']) . "%";
		$total_dt .= 's';
		$hcp = True;
	}
	if(!empty($_POST['h_cred'])){
		$total_query[] = 'HCP.HCP_CREDENTIALS = ?';
		$total_param[] = $_POST['h_cred'];
		$total_dt .= 's';
		$hcp = True;
	}
	if(!empty($_POST['h_inv'])){
		$total_query[] = 'HCP.HCP_IS_PRINCIPAL_INVESTIGATOR ' 
				. $_POST['h_inv'] . ' ?';
		$total_param[] = 'Y';
		$total_dt .='s';
		$hcp = True;
	}
	if(!empty($_POST['h_col'])){
		$total_query[] = 'HCP.HCP_IS_COLLABORATOR ' . 
					$_POST['h_col'] . ' ?';
		$total_param[] = 'Y';
		$total_dt .='s';
		$hcp = True;
	}
	if(isset($hcp)){
		$joins.= " INNER JOIN TRIAL_HCP USING(TRIAL_ID) ".
			"INNER JOIN HCP USING (HCP_ID)";
	}

	//publication

	if(!empty($_POST['p_auth'])){
		$total_query[] = 'LOWER(PUBLICATION.PUB_AUTHORS) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['p_auth']) . "%";
		$total_dt .= 's';
		$publication = True;
	}
	if(!empty($_POST['p_jour'])){
		$total_query[] = 'LOWER(PUBLICATION.PUB_JOURNAL) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['p_jour']) . "%";
		$total_dt .= 's';
		$publication = True;
	}
	if(!empty($_POST['p_tit'])){
		$total_query[] = 'LOWER(PUBLICATION.PUB_TITLE) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['p_tit']) . "%";
		$total_dt .= 's';
		$publication = True;
	}
	if(isset($publication)){
		$joins.= " INNER JOIN TRIAL_PUB USING(TRIAL_ID) ".
			"INNER JOIN PUBLICATION USING (PUB_ID)";
	}

	//sites
	if(!empty($_POST['s_name'])){
		$total_query[] = 'LOWER(SITES.SITE_NAME) LIKE ?';
		$total_param[] = "%" . strtolower($_POST['s_name']) . "%";
		$total_dt .= 's';
		$sites = True;
	}

	if(!empty($_POST['s_country'])){
		$total_query[] = 'SITES.SITE_COUNTRY LIKE ?';
		$total_param[] = '%' . $_POST['s_country'] . '%';
		$total_dt .= 's';
		$sites = True;
	}
	if(!empty($_POST['s_state'])){
		$total_query[] = 'SITES.SITE_STATE LIKE ?';
		$total_param[] = '%' . $_POST['s_state'] . '%';
		$total_dt .= 's';
		$sites = True;
	}
	if(!empty($_POST['s_city'])){
		$total_query[] = 'SITES.SITE_CITY LIKE ?';
		$total_param[] = '%' . $_POST['s_city'] . '%';
		$total_dt .= 's';
		$sites = True;
	}
	if(isset($sites)){
		$joins.= " INNER JOIN TRIAL_SITE USING(TRIAL_ID) ".
			"INNER JOIN SITES USING (SITE_ID)";
	}

	
	$final_search = 'SELECT DISTINCT TRIAL_SUMMARY.TRIAL_ID, TRIAL_SUMMARY.TRIAL_ALT_ID' .
			', TRIAL_SUMMARY.TRIAL_NAME, TRIAL_SUMMARY.TRIAL_TREATMENTS, ' .
			'TRIAL_SUMMARY.TRIAL_CTR_ENROLL, TRIAL_SUMMARY.TRIAL_STATUS, ' .
			'TRIAL_SUMMARY.TRIAL_PHASE, TRIAL_SUMMARY.TRIAL_URL ' .
			'FROM TRIAL_SUMMARY' . $joins . ' WHERE' . '(' . 
			implode(') AND (', $total_query) . ');';

	//echo $final_search . "<br><br>";
	//echo $total_dt . "<br><br>";
	//echo implode(' ', $total_param) . "<br><br>";

	if (!mysqli_stmt_prepare($stmt, $final_search)) {
			echo 'We are sorry, something went wrong<br><br>';
		}
		else{
			mysqli_stmt_bind_param($stmt, "$total_dt", ...$total_param);
			if(!mysqli_stmt_execute($stmt)){
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				echo 'Something else went wrong<br>';
			} else {
				$result = mysqli_stmt_get_result($stmt);
				$page_content .= "<table style = 'overflow: auto'><tr><th>Row</th>" .
				     "<th>Trial ID</th>" .
				     "<th>Trial Name</th>" .
				     "<th>Trial Enroll</th>" .
				     "<th>Trial URL</th>" .
				     "<th>Other Fields</th></tr>";
				$row_num = 1;
				while($row = mysqli_fetch_assoc($result)){
				   $page_content .= "<tr><td>" . $row_num . "</td>";
				   $page_content .= "<td><a href = 'full_trial.php?id=" .
					$row['TRIAL_ID'] . "&section=trial'>" . 
					$row['TRIAL_ID'] . "</a></td>";
				   $page_content .= "<td>" . $row['TRIAL_NAME'] . "</td>";
				   $page_content .= "<td>" . $row['TRIAL_CTR_ENROLL'] . 
							"</td>";
				   $page_content .= "<td><a href='" . $row['TRIAL_URL'] . "'>" . $row['TRIAL_URL'] . "</a></td>";
				   $page_content .= "<td><table><tr><td>" .
					"<a href = 'full_trial.php?id=" .
					$row['TRIAL_ID'] . "&section=treat'>" .
				        "Treatment Info</a></td>".
					"<td><a href = 'full_trial.php?id=".
					$row['TRIAL_ID'] . "&section=institute'>" .
					"Institution Info</a></td>".
					"<td><a href = 'full_trial.php?id=".
					$row['TRIAL_ID'] . "&section=sites'>" .
					"Sites Info</a></td></tr>".
					"<tr><td><a href = 'full_trial.php?id=".
					$row['TRIAL_ID'] . "&section=mesh'>" .
					"Mesh Terms Info</a></td>".
					"<td><a href = 'full_trial.php?id=".
					$row['TRIAL_ID'] . "&section=publication'>" .
					"Publication Info</a></td>".
					"<td><a href = 'full_trial.php?id=".
					$row['TRIAL_ID'] . "&section=hcp'>" .
					"Health Care Provider Info</a></td></tr>".
					"</table></td></tr>";
					$row_num++;
				}
				$page_content .= "</table>";
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
			}
		}
	echo $page_content;

?>