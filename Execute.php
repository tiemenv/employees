<?php
class Execute
{
    public static function showTitle($title)
    {
        echo "<h1>$title</h1>";
    }

    public static function showSubtitle($title)
    {
        echo "<h3>$title</h3>";
    }

    public static function showNav()
    {
        ?>
        <ul>
            <li><a href="Index.php?actie=toonLijst">Een overzicht van alle werknemers</a></li>
            <li><a href="Index.php?actie=voegtoe">Een werknemer toevoegen</a></li>
            <li><a href="Index.php?actie=toonLijstMetActie">Een werknemer verwijderen / wijzigen</a></li>
            <li><a href="Index.php?actie=zoek">Een werknemer zoeken</a></li>
        </ul>
        <hr/>
        <?php
    }

    public static function showEmployeesInTable($employeetable, $extra)
    {
        $resstring = "<table>";
        $resstring .= "<tr>";
        $resstring .= "<th>wnr</th>";
        $resstring .= "<th>wnaam</th>";
        $resstring .= "<th>afdeling</th>";
        $resstring .= "<th>ftienaam</th>";
        $resstring .= "<th>salaris</th>";
        $resstring .= "<th>vesnaam</th>";
        if ($extra) {
            $resstring .= "<th>verwijder</th>";
            $resstring .= "<th>wijzig</th>";
        }
        $resstring .= "</tr>";

        foreach ($employeetable as $employee) {
            $resstring .= "<tr>";
            $resstring .= "<td>" . Helper::cleanData($employee->wnr) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($employee->wnaam) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($employee->afdeling) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($employee->ftienaam) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($employee->salaris) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($employee->vesnaam) . "</td>";
            if ($extra) {
                $resstring .= "<td><a href=\"Index.php?actie=verwijder&wnr=" . Helper::cleanData($employee->wnr) . "\">verwijder</a></td>";
                $resstring .= "<td><a href=\"Index.php?actie=wijzig&wnr=" . Helper::cleanData($employee->wnr) . "\">wijzig</a></td>";
            }
            $resstring .= "</tr>";
        }
        $resstring .= "</table>";
        echo $resstring;
    }

    public static function showAddEmployeeForm($functiontable, $holdingtable)
    {
        ?>
        <h3>Een werknemer toevoegen</h3>
        <form action="Index.php?actie=voegtoe" method=post>
            <div>
                <label for=wnr>wnr</label>
                <input type=text size=2 name=wnr id=wnr>
            </div>
            <div>
                <label for=wnaam>wnaam</label>
                <input type=text size=15 name=wnaam id=wnaam>
            </div>
            <div>
                <label for=afdeling>afdeling</label>
                <input type=text size=2 name=afdeling id=afdeling>
            </div>
            <div>
                <label for=ftienaam>ftienaam</label>
                <select name=ftienaam id=ftienaam>
                    <?php
                    foreach($functiontable as $function)
                    {
                        echo "<option value=$function->ftienaam>".Helper::cleanData($function->ftienaam)."</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for=salaris>salaris</label>
                <input type=number name=salaris id=salaris>
            </div>
            <div>
                <label for=vesnaam>vesnaam</label>
                <select name=vesnaam id=vesnaam>
                    <?php
                    foreach($holdingtable as $holding)
                    {
                        echo "<option value=$holding->vesnaam>".Helper::cleanData($holding->vesnaam)."</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type=submit name=jaknop value=Toevoegen>
                <input type=submit name=neeknop value=Annuleren>
            </div>
        </form>

        <?php
    }

    public static function showFormToModifyEmployee($employee, $functiontable, $holdingtable)
    {
        ?>
        <h3>Een werknemer wijzigen</h3>
        <form action="Index.php?actie=wijzig" method=post>
            <div>
                <label for=wnr>wnr</label>
                <input type=text size=2 name=wnr id=wnr readonly value="<?php echo Helper::cleanData($employee->wnr); ?>">
            </div>
            <div>
                <label for=wnaam>wnaam</label>
                <input type=text size=15 name=wnaam id=wnaam value="<?php echo Helper::cleanData($employee->wnaam); ?>">
            </div>
            <div>
                <label for=afdeling>afdeling</label>
                <input type=text size=2 name=afdeling id=afdeling
                       value="<?php echo Helper::cleanData($employee->afdeling); ?>">
            </div>
            <div>
                <label for=ftienaam>ftienaam</label>
                <select name=ftienaam id=ftienaam>
                    <?php
                    foreach($functiontable as $function)
                    {
                        if($function->ftienaam == $employee->ftienaam)
                        {
                            echo "<option value=$function->ftienaam selected>".Helper::cleanData($function->ftienaam)."</option>";
                        }
                        else
                        {
                            echo "<option value=$function->ftienaam>".Helper::cleanData($function->ftienaam)."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for=salaris>salaris</label>
                <input type=number name=salaris id=salaris value="<?php echo Helper::cleanData($employee->salaris); ?>">
            </div>
            <div>
                <label for=vesnaam>vesnaam</label>
                <select name=vesnaam id=vesnaam>
                    <?php
                    foreach($holdingtable as $holding)
                    {
                        if($holding->vesnaam == $employee->vesnaam)
                        {
                            echo "<option value=$holding->vesnaam selected>".Helper::cleanData($holding->vesnaam)."</option>";
                        }
                        else
                        {
                            echo "<option value=$holding->vesnaam>".Helper::cleanData($holding->vesnaam)."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type=submit name=jaknop value=Wijzigen>
                <input type=submit name=neeknop value=Annuleren>
            </div>
        </form>

        <?php
    }

    public static function confirmDeletion($employeenumber)
    {
        ?>
        <h3>Ben je zeker dat je de werknemer wilt verwijderen?</h3>
        <form action="Index.php?actie=verwijder" method=post>
            <input type=hidden name=wnr value="<?php echo Helper::cleanData($employeenumber); ?>">
            <div>
                <input type=submit name=jaknop value=Verwijderen>
                <input type=submit name=neeknop value=Annuleren>
            </div>
        </form>
        <?php
    }

    public static function showFormToShowEmployees()
    {
//	    Als de gegevens met get worden doorgestuurd, dan een hidden veld toevoegen:
//	    <input type=”hidden” name=”actie” value=”zoek” >
       ?>
        <h3>Een werknemer zoeken</h3>
        <form action="Index.php?actie=zoek" method=post>
            <div>
                <input type=radio name=kolomnaam value=wnaam id=wnaam checked=checked>
                <label for=wnaam>naam</label>
                <br />
                <input type=radio name=kolomnaam value=vesnaam id=vesnaam>
                <label for=vesnaam>vestiging</label>
            </div>
            <div>
                bevat
            </div>
            <div>
                <input type=text name=zoekwaarde>
            </div>
            <div>
                <input type=submit name=jaknop value=Zoeken>
                <input type=submit name=neeknop value=Annuleren>
            </div>
        </form>

        <?php
    }
}

