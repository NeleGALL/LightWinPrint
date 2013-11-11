. ./config.ps1

Add-Type -Path "C:\Program Files (x86)\MySQL\MySQL Connector Net 6.6.5\Assemblies\v2.0\MySql.Data.dll"
get-date -DisplayHint date -UFormat %d.%m.%y
$connectionString = "server=" + $mysql_ip + ";uid=" + $mysql_user + ";pwd=" + $mysql_pass + ";database=" + $mysql_database + ";"
function Execute-MySQLQuery([string]$query) {
    $cmd = New-Object MySql.Data.MySqlClient.MySqlCommand($query, $connectionString)
    $dataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($cmd)
    $dataSet = New-Object System.Data.DataSet
    $dataAdapter.Fill($dataSet, "data")
    $cmd.Dispose()
    return $dataSet.Tables["data"]
}
$connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$connection.ConnectionString = $connectionString
$connection.Open()
$sql = New-Object MySql.Data.MySqlClient.MySqlCommand
$sql.Connection = $connection
$today = get-date -DisplayHint date -UFormat %d.%m.%y
Get-WinEvent -FilterHashTable @{LogName="Microsoft-Windows-PrintService/Operational";starttime="$today";id=307} | Foreach {
	$event = [xml]$_.ToXml()
	if($event)
	{
		$Time = Get-Date $_.TimeCreated -UFormat "%Y-%m-%d %H:%M"
		$Job = $event.Event.UserData.DocumentPrinted.Param1 
		$Document = $event.Event.UserData.DocumentPrinted.Param2.ToString().Replace("\","\\") 
		$User = $event.Event.UserData.DocumentPrinted.Param3 
		$Port = $event.Event.UserData.DocumentPrinted.Param6 
		$Printer = $event.Event.UserData.DocumentPrinted.Param5 
		$Size = $event.Event.UserData.DocumentPrinted.Param7 
		$Pages = $event.Event.UserData.DocumentPrinted.Param8
        $sqlq = "SELECT * FROM " + $mysql_table + " WHERE `Time`='$Time' AND `Job`='$Job'"
        $result = Execute-MySQLQuery($sqlq)
        $ress=$result.rows.count
        if($result -eq 0) {
            $sql.CommandText = "INSERT IGNORE INTO " + $mysql_table + " (User,Printer,Port,Time,Document,Pages,Size,Job) VALUES ('$User','$Printer','$Port','$Time','$Document','$Pages','$Size','$Job')"
            $sql.ExecuteNonQuery()
        }
	} 
} 
Write-Verbose -Message "DONE" -verbose