<?php
class Lesdb
{
	private static $lesdbinstance = null;

	private $db;

	private function __construct()
	{
		try
		{
            $config = Config::getConfigInstance();
            $server = $config->getServer();
            $database = $config->getDatabase();
            $username = $config->getUsername();
            $password = $config->getPassword();

            $this->db = new PDO("mysql:host=$server; dbname=$database; charset=utf8mb4",
                $username,
                $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public static function getLesdbInstance()
	{
		if(is_null(self::$lesdbinstance))
		{
			self::$lesdbinstance = new Lesdb();
		}
		return self::$lesdbinstance;
	}

	public function closeDB()
	{
		self::$lesdbinstance = null;
	}

	public function getAllExmployees()
	{
		try
		{
			$sql = "SELECT * FROM werknemers";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$employeetable = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}

		return $employeetable;
	}

    public function getAllFunctions()
    {
        try
        {
            $sql = "SELECT * FROM functies";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $functiontable = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

        return $functiontable;
    }

    public function getAllHoldings()
    {
        try
        {
            $sql = "SELECT * FROM vestigingen";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $holdingtable = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

        return $holdingtable;
    }

	public function getEmployeeByNumber($wnr)
	{
		try
		{
			$sql = "SELECT * FROM werknemers
                        WHERE wnr = :wnr";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":wnr", $wnr);
			$stmt->execute();
			$employee = $stmt->fetch(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}

        if(empty($employee))
        {
            die("Werknemer niet gevonden");
        }
		return $employee;
	}

	public function addEmployee($wnr, $wnaam, $afdeling, $ftienaam, $salaris, $vesnaam)
	{
		try
		{
			$sql = "INSERT INTO werknemers(wnr, wnaam, afdeling, ftienaam, salaris, vesnaam)
						VALUES(:wnr, :wnaam, :afdeling,:ftienaam, :salaris, :vesnaam)";

			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(":wnr", $wnr);
			$stmt->bindParam(":wnaam", $wnaam);
			$stmt->bindParam(":afdeling", $afdeling);
			$stmt->bindParam(":ftienaam", $ftienaam);
			$stmt->bindParam(":salaris", $salaris);
			$stmt->bindParam(":vesnaam", $vesnaam);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public function deleteEmployeeByNumber($employeenumber)
	{
		try
		{
			$sql = "DELETE FROM werknemers
                          WHERE wnr = :wnr";

			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(":wnr", $employeenumber);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public function modifyEmployee($employeenumber, $employeename, $department, $function, $salary, $holding)
	{
		try
		{
			$sql = "UPDATE werknemers
							SET wnaam = :wnaam,
								afdeling = :afdeling,
								ftienaam = :ftienaam,
								salaris = :salaris,
								vesnaam = :vesnaam
							WHERE wnr = :wnr";

			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(":wnaam", $employeename);
			$stmt->bindParam(":afdeling", $department);
			$stmt->bindParam(":ftienaam", $function);
			$stmt->bindParam(":salaris", $salary);
			$stmt->bindParam(":vesnaam", $holding);
			$stmt->bindParam(":wnr", $employeenumber);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

    public function searchEmployees($columnname, $searchvalue)
    {
        try
        {
            //Een kolomnaam (of tabelnaam) kan niet als parameter opgegeven worden
            switch ($columnname)
            {
                case "wnaam": $sql = "SELECT * FROM werknemers
                                      WHERE wnaam LIKE :zoekwaarde";
                    break;
                case "vesnaam": $sql = "SELECT * FROM werknemers
                                      WHERE vesnaam LIKE :zoekwaarde";
                    break;
                default: die("Foute kolomnaam");
            }

            $stmt = $this->db->prepare($sql);

            $searchvalue = "%$searchvalue%";
            $stmt->bindParam(":zoekwaarde", $searchvalue);

            $stmt->execute();

            $employeetable = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

        return $employeetable;
    }
}

