<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
<?php 
$filename = "courses.tsv";
$lines = file($filename);
$totalNumberOfCourses = count($lines); 
$sizeFiles = filesize($filename);



?>

    <p>
        Course list has <?= $totalNumberOfCourses ?> total courses
        and
        size of <?= $sizeFiles ?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>
<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
		//Number of today's courses
		if(!($_GET["number_of_courses"]))
		{
			$numberOfCourses = 3;
		}
		else
		{
			$numberOfCourses = $_GET["number_of_courses"];
		}
		
            function getCoursesByNumber($listOfCourses, $numberOfCourses)
			{
                $resultArray = array();
				
				$listOfNumber = array();
				
				while(count($listOfNumber)<$numberOfCourses)
				{
					$randNumber = rand(0,count($listOfCourses)-1);
					
					if(!in_array($randNumber,$listOfNumber))
					{
						array_push($listOfNumber,$randNumber);
						array_push($resultArray,$listOfCourses[$randNumber]);
					}
				}
			
                return $resultArray;
            }
			
			//List of courses that will be hold today
			$todaysCourses = getCoursesByNumber($lines,$numberOfCourses);
			
			//var_dump($todaysCourses);
        ?>
        <ol>
			<?php
			foreach($todaysCourses as $cours)
			{
				print "<li>".$cours."</li>";
			}?>
			
        </ol>
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        <?php
		
			if(empty($_GET["character"]))
			{
				$startCharacter = "C";
			}
			else
			{
				$startCharacter = $_GET["character"];
			}
			
		
            function getCoursesByCharacter($listOfCourses, $startCharacter)
			{
                $resultArray = array();
				
				foreach($listOfCourses as $cours)
				{
					if(substr($cours,0,1) == $startCharacter)
					{
						array_push($resultArray,$cours);
					}
				}
				
                return $resultArray;
            }
			
			$searchedCourses = getCoursesByCharacter($lines,$startCharacter);
        ?>
        <p>
            Courses that started by <strong>'<?= $startCharacter ?>'</strong> are followings :
        </p>
        <ol>
			<?php
			foreach($searchedCourses as $cours)
			{
				print "<li>".$cours."</li>";
			}?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php
			//0 --> alphabetical order
			//1 --> alphabetical reverse order
			if(!($_GET["orderby"]))
			{
				$orderby = 0;
			}
			else
			{
				$orderby = $_GET["orderby"];
			}
			
            function getCoursesByOrder($listOfCourses, $orderby)
			{
                $resultArray = $listOfCourses;
                
				if($orderby == 0)
				{
					sort($listOfCourses);
				}
				else
				{
					rsort($listOfCourses);
				}
				$resultArray = $listOfCourses;
				
                return $resultArray;
            }
			
			
			$orderedCourses = getCoursesByOrder($lines,$orderby);
			
        ?>
        <p>
            All of courses ordered by <strong>alphabetical order</strong> are followings :
        </p>
        <ol>
			<?php
			foreach($orderedCourses as $cours)
			{
				if(strlen($cours)>29)
				{
					print "<li class=\"long\">".$cours."</li>";
				}
				else
				{
					print "<li>".$cours."</li>";
				}
			}?>
        </ol>
    </div>
    <div class="section">
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
<?php
	

	if(!isset($newCourse) || !isset($codeOfCourse))
	{
		print "<p>Input course or code of the course doesn't exist.</p>";
	}
	else
	{
		$newCourse = $_GET["new_course"];
		$codeOfCourse = $_GET["code_of_course"];
		
		array_push($lines,$newCourse." ".$codeOfCourse);
		
		file_put_contents($filename,"\n".$newCourse." _ ".$codeOfCourse,FILE_APPEND);
		
		print "<p>Adding cours is success !.</p>";
		
	}
        

?>		
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>