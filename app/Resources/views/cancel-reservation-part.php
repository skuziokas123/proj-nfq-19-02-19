<?php
echo "<td>".$reservation->getVisitDate()->format('Y-m-d H:i:s')."</td>";
echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=cancelReservation&id=".$reservation->getId()."&workerId=".$selectWorker."&name=".$name."&dateTime=".$reservation->getVisitDate()->format('Y-m-d H:i:s')."'>[Atšaukti]</a></td>";
