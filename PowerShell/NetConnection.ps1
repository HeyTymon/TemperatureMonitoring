function Connection-Configuration {
    [CmdletBinding()]
    param(
        [Parameter(ValueFromPipeline)]
        [Object] $Target
    )

    begin {
        Write-Host Starting connection test...
    }

    process {
      Test-NetConnection -ComputerName $Target.IP -Port $Target.port
    }

}


function Get-Address-List {
    $AddressObjectList = New-Object System.Collections.ArrayList

    for($i = 0; $i -lt ($AddressesNumber-1); $i += 2) {

    $valueIP = $Addresses | Select -Skip $i -First 1
    $valuePort = $Addresses | Select -Skip ($i+1) -First 1

    $tempAddress = New-Object System.Object
    $tempAddress | Add-Member -MemberType NoteProperty -Name "IP" -Value $valueIP
    $tempAddress | Add-Member -MemberType NoteProperty -Name "port" -Value $valuePort
    $AddressObjectList.Add($tempAddress)  | Out-Null
    }

    return $AddressObjectList
}

$addressesFileName = Read-Host "File name (only .txt)"

Clear-Host

$Addresses = Get-Content "$PSScriptRoot\$addressesFileName.txt"
$AddressesNumber = (Get-Content "$PSScriptRoot\Addresses.txt").Length

$AddressObjectList = Get-Address-List

$AddressObjectList | % { 
    $_ | Connection-Configuration 
}