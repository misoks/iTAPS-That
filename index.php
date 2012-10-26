<?php


?>

<html>

<head>
    <title>iTAPS That Project</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
</head>

<body>

    <h1>iTAPS That: A Digital Tracking and Planning Sheet</h1>
    <h2>All Specializations</h2>    
    <h3>Foundations</h3>
    <ul>
        <li>SI 500: Information in Social Systems
        <li>SI 501: Contextual Inquiry and Project Management
        <li>SI 502: Networked Computing
    </ul>
    <h3>Management (3 Credits)</h3>
        <select name="management">
            <option value="coursenumber">Course Name</option>
        </select>
    <h3>Research Methods (3 Credits)</h3>
        <select name="research_methods">
            <option value="coursenumber">Course Name</option>
        </select>
    <h3>Cognate (3-6 Credits)</h3>
    <table>
        <tr>
            <td>&nbsp;</td>
            <td>Course Number</td>
            <td>Course Title</td>
            <td>Credits</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="text" class="course-prefix" name="cognate_prefix"></td>
            <td><input type="text" class="course-title" name="cognate_coursetitle"></td>
            <td><input type="text" class="course-credits" name="cognate_credits"></td>
        </tr>
        <tr class="caption">
            <td>e.g.</td>
            <td> MKT 618</td>
            <td> Marketing Research</td>
            <td> 3</td>
        </tr>
    </table>
    <h2>HCI (15 Credits)</h2>
    <h3>Required</h3>
    <ul>
        <li>SI 582: Introduction to Interaction Design
        <li>SI 588: Fundamentals of Human Behavior
        <li>SI 622: Needs Assessment and Usability Evaluation
    </ul>
    <h3>Programming Requirement (6 credits)</h3>
        <select name="programming">
            <option value="coursenumber">Course Name</option>
        </select>
    <h3>Statistics Requirement (3 credits)</h3>
        <select name="statistics">
            <option value="coursenumber">Course Name</option>
        </select>
    <h3>Other HCI Courses</h3>
        <select name="HCI_misc">
            <option value="coursenumber">Course Name</option>
        </select>
    <h3>Additional Courses</h3>
    <table>
        <tr>
            <td>&nbsp;</td>
            <td>Course Number</td>
            <td>Course Title</td>
            <td>Credits</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="text" class="course-prefix" name="addtnl_prefix"></td>
            <td><input type="text" class="course-title" name="addtnl_coursetitle"></td>
            <td><input type="text" class="course-credits" name="addtnl_credits"></td>
        </tr>
        <tr class="caption">
            <td>e.g.</td>
            <td>SI 535</td>
            <td>Dead Media</td>
            <td>3</td>
        </tr>
    </table>
    <h2>Total Credits: 48+</h2>
</body>

</html>