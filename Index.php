<?php
require_once 'head.php';
require_once 'General.php';

Execute::showTitle("Werken met de MySQL-databank LesDB");
Execute::showNav();

$lesdb = Lesdb::getLesdbInstance();

$action = isset($_GET["actie"]) ? $_GET["actie"] : "";

switch ($action)
{
    case "toonLijst":
        Execute::showSubtitle("Werknemers uit LesDB");
        Execute::showEmployeesInTable($lesdb->getAllExmployees(), false);
        break;
    case "toonLijstMetActie":
        Execute::showSubtitle("Werknemers uit LesDB met actiemogelijkheid");
        Execute::showEmployeesInTable($lesdb->getAllExmployees(), true);
        break;
    case "voegtoe":
        if (empty($_POST))
        {
            Execute::showAddEmployeeForm($lesdb->getAllFunctions(),
                $lesdb->getAllHoldings());
        }
        elseif (isset($_POST["jaknop"]))
        {
            $lesdb->addEmployee($_POST["wnr"], $_POST["wnaam"],
                    $_POST["afdeling"], $_POST["ftienaam"],
                    $_POST["salaris"], $_POST["vesnaam"]);
        }
        break;
    case "verwijder":
        if (empty($_POST))
        {
            $toDelete = $_GET["wnr"];
            $employee = $lesdb->getEmployeeByNumber($toDelete);
            Execute::showSubtitle("De geselecteerde werknemer");
            Execute::showEmployeesInTable(array($employee), false);
            Execute::confirmDeletion($toDelete);
        }
        elseif (isset($_POST["jaknop"]))
        {
            $lesdb->deleteEmployeeByNumber($_POST["wnr"]);
        }
        break;
    case "wijzig":
        if(empty($_POST))
        {
            $toModify = $_GET["wnr"];
            $employee = $lesdb->getEmployeeByNumber($toModify);
            Execute::showFormToModifyEmployee($employee,
                $lesdb->getAllFunctions(),
                $lesdb->getAllHoldings());
        }
        elseif (isset($_POST["jaknop"]))
        {
            $lesdb->modifyEmployee($_POST["wnr"], $_POST["wnaam"],
                $_POST["afdeling"], $_POST["ftienaam"],
                $_POST["salaris"], $_POST["vesnaam"]);
        }
        break;
    case "zoek":
        if(empty($_POST))
        {
            Execute::showFormToShowEmployees();
        }
        elseif (isset($_POST["jaknop"]))
        {
            Execute::showSubtitle("Resultaat van de zoekopdracht");
            Execute::showEmployeesInTable($lesdb->searchEmployees($_POST["kolomnaam"], $_POST["zoekwaarde"]), false);
        }
        break;
}

$lesdb->closeDB();

require_once 'footer.php';

