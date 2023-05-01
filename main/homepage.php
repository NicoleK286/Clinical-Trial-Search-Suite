<html>
<head>
<style> 
	body {
		background-image: url('CTsearch2.png');
		background-repeat: y-repeat;
	}
	a {
		color: black
	} 
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
	$title = 'Homepage';
	include "../inc/header.inc.php";
	if (isset($_SESSION['uid'])){
		echo "<h1>Welcome back!</h1>";
	}
?>
<div class="container-fluid">
<div id='main_page'>
	<h1 style="color: black;">COMPREHENSIVE CLINICAL TRIAL SEARCH</h1><br><br><br>
	<p style="color: black;font-size: 20px;">Clinical Trials are research studies on human volunteers designed to test the behavior and efficacy 
		of pharmaceutical treatments and interventional methods that can be used to treat any disease. </p><br>

	<p style="color: black;font-size: 20px;">	This site provides access to a curated repository of Clinical Trials information compiled from various public 
		sources such as <a href="https://beta.clinicaltrials.gov/">Clinicaltrials.gov</a> and 
		<a href="https://eudract.ema.europa.eu/">EudraCT</a> that can be used to analyze trial information 
		for research and commercial purposes.</p><br><br>
		

	<p style="color: black;font-size: 20px;">Users can navigate trial information using a combination of the following search options:</p>
	<p style="color: black;font-size: 20px;">



        <h2 style="color: black;">TRIAL DETAILS</h2>
        <p style="color: black;font-size: 20px;">
          This pertains to study set-up details of a trial that provide information about the current activity of a trial. Search criteria include:
        </p>
        <ul >
          <li style="color: black;font-size: 20px;">Trial ID: The unique identifier assigned to a trial.</li>
          <li style="color: black;font-size: 20px;">Trial Name: Name of the trial.</li>
		      <li style="color: black;font-size: 20px;">Trial Start: The initiation date of a trial.</li>
		      <li style="color: black;font-size: 20px;">Trial End: The expected completion date of a trial.</li>
		      <li style="color: black;font-size: 20px;">Recruitment Start: Patient recruitment start date.</li>
		      <li style="color: black;font-size: 20px;">Recruitment End: Patient recruitment end date.</li>
		      <li style="color: black;font-size: 20px;">Trial Status: Status refers to whether a trial is ongoing, has been completed or any other status update.</li>
		      <li style="color: black;font-size: 20px;">Trial Phase: Denotes the scope of a study from pilot safety study to large scale human trials or post marketing safety studies.</li>
		      <li style="color: black;font-size: 20px;">Trial Country: Country the study is being conducted in. A given trial can be conducted in one or multiple countries</li>
        </ul>
   <br><br>

        <h2 style="color: black;">TREATMENTS & INTERVENTIONS</h2>
        <p style="color: black;font-size: 20px;">
          This refers to pharmaceutical products, therapeutic and interventional methods that can be used in a study:
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">Treatment Name: Name of treatment used.</li>
          <li style="color: black;font-size: 20px;">Mode of Action: The method by which a therapy induces an affect.</li>
		      <li style="color: black;font-size: 20px;">Small Molecule: Is the therapy a low molecular weight organic compound.</li>
        </ul>
  <br><br>

        <h2 style="color: black;">PARICIPATING INSTITUTIONS</h2>
        <p style="color: black;font-size: 20px;">
          This tab can be used to specify information about :
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">Institute Name</li>
          <li style="color: black;font-size: 20px;">Location: Can be searched by Country, State and City.</li>
		      <li style="color: black;font-size: 20px;">Sponsor or Collaborator: Participating institutes can either financially sponsor a trial 
			or collaborate with a sponsoring institution on a trial.</li>
		  
        </ul>
  <br><br>

        <h2 style="color: black;">MESH TERMS</h2>
        <p style="color: black;font-size: 20px;">
          Medical Subject Headings (MESH) are standardized keywords that are used to </br> hierarcharily 
		  index, catalog and search biomedical information.
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">MESH Term: The specific term.</li>
          <li style="color: black;font-size: 20px;">Indication: Associated disease, if any.</li>
		      <li style="color: black;font-size: 20px;">Cancer Stage: Is the term related to a cancer stage?.</li>
        </ul>
<br><br>

        <h2 style="color: black;">ASSOCIATED PUBLICATIONS</h2>
        <p style="color: black;font-size: 20px;">
          This can be used to search published information about a trial, if it is available.
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">Author: Authors who wrote the publication.</li>
          <li style="color: black;font-size: 20px;">Journal Name: Journal the article was published in.</li>
		      <li style="color: black;font-size: 20px;">Publication Title: Title of the article.</li>
        </ul>
<br><br>

        <h2 style="color: black;">TRIAL SITES</h2>
        <p style="color: black;font-size: 20px;">
          Trials can be conducted at various sites depending on the scale and scope of a trial. </br>
		      This tab can used to find information for disclosed sites where a trial is conducted:
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">Site Name</li>
          <li style="color: black;font-size: 20px;">Location: Can be searched by Country, State and City.</li>

        </ul>
<br><br>

        <h2 style="color: black;">HEALTH CARE PERSONNEL</h2>
        <p style="color: black;font-size: 20px;">
          HCPs are physicians and researchers who participate in conducting a trial and 
		  are responsible for managing the study. </br> A HCP can also be an investigator or a collaborator:
        </p>
        <ul>
          <li style="color: black;font-size: 20px;">Full Name.</li>
          <li style="color: black;font-size: 20px;">Credentials: Qualifications of HCP.</li>
		      <li style="color: black;font-size: 20px;">Investigator: Is the HCP an Investigator?</li>
          <li style="color: black;font-size: 20px;">Collaborator: Is the HCP a Collaborator?</li>
        </ul>
     <br><br>
    </li>


</p>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>