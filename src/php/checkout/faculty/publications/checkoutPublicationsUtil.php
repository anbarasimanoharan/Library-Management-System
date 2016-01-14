<?php
//require_once('../../../connections/Connection.php');
function get_no_request_sql($UnityId,$conn) {
	$sql = "SELECT DISTINCT
             p.\"TYPE\",
             p.\"IDENTIFIER\",
             p.\"Location\",
             p.\"IsAvailable\"
        FROM ALAKSHM6.PUBLICATIONS p
       WHERE (p.\"TYPE\", p.\"IDENTIFIER\") IN
                (SELECT w.\"Type\", w.\"Identifier\"
                   FROM ALAKSHM6.PUBLICATION_WAITLIST w
                  WHERE w.\"UnityId\" = '{$UnityId}'
                 UNION
                 SELECT p2.\"TYPE\", p2.\"IDENTIFIER\"
                   FROM ALAKSHM6.PUBLICATIONS p2
                  WHERE p2.\"ID\" IN
                           (SELECT c.\"ID\"
                              FROM PUBLICATION_CHECKOUT c
                             WHERE     c.\"UnityId\" = '{$UnityId}'
                                   AND c.\"ReturnDate\" = CAST('31/DEC/9999' AS TIMESTAMP)))";
	return run_sql($conn,$sql);
}

function get_can_be_checked_out_sql($UnityId,$conn) {
	$sql = "SELECT DISTINCT
             p.\"TYPE\",
             p.\"IDENTIFIER\",
             p.\"Location\",
             p.\"IsAvailable\"
        FROM PUBLICATIONS p
       WHERE p.\"IsAvailable\" = 'Y'
      MINUS
      SELECT DISTINCT
             p1.\"TYPE\",
             p1.\"IDENTIFIER\",
             p1.\"Location\",
             p1.\"IsAvailable\"
        FROM PUBLICATIONS p1
       WHERE (p1.\"TYPE\", p1.\"IDENTIFIER\") IN
                (SELECT w.\"Type\", w.\"Identifier\"
                   FROM ALAKSHM6.PUBLICATION_WAITLIST w
                  WHERE w.\"UnityId\" = '{$UnityId}'
                 UNION
                 SELECT p2.\"TYPE\", p2.\"IDENTIFIER\"
                   FROM ALAKSHM6.PUBLICATIONS p2
                  WHERE p2.\"ID\" IN
                           (SELECT c.\"ID\"
                              FROM PUBLICATION_CHECKOUT c
                             WHERE     c.\"UnityId\" = '{$UnityId}'
                                   AND c.\"ReturnDate\" = CAST('31/DEC/9999' AS TIMESTAMP)))";
	return run_sql($conn,$sql);
}

function get_add_to_waitlist_sql($UnityId,$conn) {
	$sql = "SELECT DISTINCT
             p.\"TYPE\",
             p.\"IDENTIFIER\",
             p.\"Location\",
             p.\"IsAvailable\"
        FROM PUBLICATIONS p
       WHERE p.\"IsAvailable\" = 'N'
       AND (p.\"TYPE\",p.\"IDENTIFIER\") NOT IN
       		(SELECT p3.\"TYPE\",p3.\"IDENTIFIER\" 
       		 FROM PUBLICATIONS p3
       		 WHERE p3.\"IsAvailable\" = 'Y')
      MINUS
      SELECT DISTINCT
             p1.\"TYPE\",
             p1.\"IDENTIFIER\",
             p1.\"Location\",
             p1.\"IsAvailable\"
        FROM PUBLICATIONS p1
       WHERE (p1.\"TYPE\", p1.\"IDENTIFIER\") IN
                (SELECT w.\"Type\", w.\"Identifier\"
                   FROM ALAKSHM6.PUBLICATION_WAITLIST w
                  WHERE w.\"UnityId\" = '{$UnityId}'
                 UNION
                 SELECT p2.\"TYPE\", p2.\"IDENTIFIER\"
                   FROM ALAKSHM6.PUBLICATIONS p2
                  WHERE p2.\"ID\" IN
                           (SELECT c.\"ID\"
                              FROM PUBLICATION_CHECKOUT c
                             WHERE     c.\"UnityId\" = '{$UnityId}'
                                   AND c.\"ReturnDate\" = CAST('31/DEC/9999' AS TIMESTAMP)))";
	return run_sql($conn,$sql);
}

function run_sql($conn,$sql) {
	var_dump($sql);
	$query = oci_parse($conn, $sql);
	oci_execute($query);
	$nrows = oci_fetch_all($query, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
	echo "$nrows rows fetched<br>\n";
	var_dump($result);
	if (!$result) {
		echo oci_error();
		return null;
	}else{
		return $result;
	}
}

?>