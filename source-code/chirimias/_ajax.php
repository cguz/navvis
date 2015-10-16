<?php
	session_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	
	$opc=$_GET["nl"];
	
	if($opc==1)
	{
		echo"<br><p>Chirimias ist ein Kulturprojekt, welches die kulturellen und artistischen F&auml;higkeiten f&ouml;rdert.</p>
              <p>F&uuml;r Kinder, die daran interessiert sind, die lateinamerikanische und spanische Kultur kennen zu lernen.</p>
              <p>Unsere Absicht ist es, die kulturelle Bildung zu verst&auml;rken, die Neugier in den Kindern zu erwecken und unsere Kulturen zu bewahren.</p>
              <p>Unser Hauptaugenmerk liegt darin, die Traditionen aufrechtzuerhalten.</p>";
	}
	if($opc==2)
	{
		echo"<br><p align='center'><strong>Taller de Percusi&oacute;n</strong></p>
             <p>&nbsp;</p>
             <p>Durch Bewegung, Klatschen, Stimme und Gesang das Rhytmusgef&uuml;hl entwickeln.</p>
             <p>Einbeziehung von Small-Percussion <br />(Rasseln, Klangh&ouml;lzer usw).</p>";
	}
	if($opc==3)
	{
		echo"<br><p align='center'><strong>Taller de Expresi&oacute;n</strong></p>
             <p>&nbsp;</p>
             <p>Die Kinder lernen neue Techniken, Bilder zu malen, die dazu beitragen, um in kleinen Gruppen B&uuml;cher zu schreiben und illustrieren.</p>
             <p>Auch kleine Theaterst&uuml;cke werden vorbereitet und vorgef&uuml;hrt.</p>";
	}
	if($opc==4)
	{
		echo"<br><p align='center'><strong>Historia del arte y la cultura</strong></p>
             <p>&nbsp;</p>
             <p>Durch Erz&auml;hlungen und Referate wird den Kindern das Grundwissen der Kunst-und Kulturgeschichte n&auml;her gebracht.</p>
             <p>&nbsp;</p>";
	}
	if($opc==5)
	{
		echo"<br><p align='center'><strong>Talleres de danza y expresi&oacute;n corporal</strong></p>
             <p>&nbsp;</p>
             <p>Hier lernen die Kinder den eigenen K&ouml;rper, mit Hilfe des Tanzes, der Musik und den verchiedenen Rhythmen der Folklore wie z.B. Salsa, Cumbia, Flamenco und Sevillana kennen.</p>
             <p>&nbsp;</p>";
	}
	if($opc==6)
	{
		echo"<br><p align='center'><strong>Talleres literarios</strong></p>
             <p>&nbsp;</p>
             <p>In diesem Workshop wird traditionelle Kinderliteratur behandelt, aber auch das Verfassen eigener Texte kommt nicht zu kurz. Diese tragen dazu bei, die Entwicklung der Kinder zu verbessen.</p>
             <p>&nbsp;</p>";
	}
	if($opc==7)
	{
		echo"<br><p align='center'><strong>Kontakt</strong></p>
             <p>Chirimias Iberoam.infantil <br> Hilden 2004 e.V. <br> Janeth Kriemer & Luz Elena Diaz</p>
             <p>&nbsp;</p>
             <p>D&uuml;rerweg 4E <br> 40724 Hilden <br> Tel:02103-242090 <br> E-Mail: info@chirimias.com</p>";
	}
?>