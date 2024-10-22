<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barangay_name = $_POST['barangay_name'] ?? '';

    if (!empty($barangay_name)) {
        // Fetch barangay_id
        $query = "SELECT id FROM barangays WHERE barangay_name = :barangay_name";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':barangay_name', $barangay_name, PDO::PARAM_STR);
        $stmt->execute();
        $barangay_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($barangay_row) {
            $barangay_id = $barangay_row['id'];

            // Fetch MOV files, including the relevant PDF fields
            $query = "
                SELECT IA_1a_pdf_File, IA_1b_pdf_File, IA_2a_pdf_File, IA_2b_pdf_File, 
                       IA_2c_pdf_File, IA_2d_pdf_File, IA_2e_pdf_File, IB_1forcities_pdf_File, 
                       IB_1aformuni_pdf_File, IB_1bformuni_pdf_File, IB_2_pdf_File, IB_3_pdf_File, 
                       IB_4_pdf_File, IC_1_pdf_File, IC_2_pdf_File, ID_1_pdf_File, ID_2_pdf_File, 
                       IIA_pdf_File, IIB_1_pdf_File, IIB_2_pdf_File, IIC_pdf_File, IIIA_pdf_File, 
                       IIIB_pdf_File, IIIC_1forcities_pdf_File, IIIC_1forcities2_pdf_File, 
                       IIIC_1forcities3_pdf_File, IIIC_2formuni1_pdf_File, IIIC_2formuni2_pdf_File, 
                       IIIC_2formuni3_pdf_File, IIID_pdf_File, IV_forcities_pdf_File, IV_muni_pdf_File, 
                       V_1_pdf_File, threepeoplesorg, id AS mov_id 
                FROM mov 
                WHERE barangay_id = :barangay_id
            ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();
            $mov_row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($mov_row) {
                // Fetch movrate data
                $rate_query = "
                    SELECT `id`, `barangay`, `mov_id`, `IA_1a_pdf_rate`, `IA_1b_pdf_rate`, `IA_2a_pdf_rate`, 
                           `IA_2b_pdf_rate`, `IA_2c_pdf_rate`, `IA_2d_pdf_rate`, `IA_2e_pdf_rate`, 
                           `IB_1forcities_pdf_rate`, `IB_1aformuni_pdf_rate`, `IB_1bformuni_pdf_rate`, 
                           `IB_2_pdf_rate`, `IB_3_pdf_rate`, `IB_4_pdf_rate`, `IC_1_pdf_rate`, `IC_2_pdf_rate`, 
                           `ID_1_pdf_rate`, `ID_2_pdf_rate`, `IIA_pdf_rate`, `IIB_1_pdf_rate`, `IIB_2_pdf_rate`, 
                           `IIC_pdf_rate`, `IIIA_pdf_rate`, `IIIB_pdf_rate`, `IIIC_1forcities_pdf_rate`, 
                           `IIIC_1forcities2_pdf_rate`, `IIIC_1forcities3_pdf_rate`, `IIIC_2formuni1_pdf_rate`, 
                           `IIIC_2formuni2_pdf_rate`, `IIIC_2formuni3_pdf_rate`, `IIID_pdf_rate`, 
                           `IV_forcities_pdf_rate`, `IV_muni_pdf_rate`, `V_1_pdf_rate`, `threepeoplesorg_rate`
                    FROM movrate
                    WHERE mov_id = :mov_id AND barangay = :barangay_id
                ";
                $stmt = $conn->prepare($rate_query);
                $stmt->bindParam(':mov_id', $mov_row['mov_id'], PDO::PARAM_INT);
                $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
                $stmt->execute();
                $movrate_row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Fetch movremark data
                $remark_query = "
                    SELECT `id`, `barangay`, `mov_id`, `IA_1a_pdf_remark`, `IA_1b_pdf_remark`, `IA_2a_pdf_remark`, 
                           `IA_2b_pdf_remark`, `IA_2c_pdf_remark`, `IA_2d_pdf_remark`, `IA_2e_pdf_remark`, 
                           `IB_1forcities_pdf_remark`, `IB_1aformuni_pdf_remark`, `IB_1bformuni_pdf_remark`, 
                           `IB_2_pdf_remark`, `IB_3_pdf_remark`, `IB_4_pdf_remark`, `IC_1_pdf_remark`, 
                           `IC_2_pdf_remark`, `ID_1_pdf_remark`, `ID_2_pdf_remark`, `IIA_pdf_remark`, 
                           `IIB_1_pdf_remark`, `IIB_2_pdf_remark`, `IIC_pdf_remark`, `IIIA_pdf_remark`, 
                           `IIIB_pdf_remark`, `IIIC_1forcities_pdf_remark`, `IIIC_1forcities2_pdf_remark`, 
                           `IIIC_1forcities3_pdf_remark`, `IIIC_2formuni1_pdf_remark`, `IIIC_2formuni2_pdf_remark`, 
                           `IIIC_2formuni3_pdf_remark`, `IIID_pdf_rate_remark`, `IV_forcities_pdf_remark`, 
                           `IV_muni_pdf_remark`, `V_1_pdf_remark`, `threepeoplesorg_remark`
                    FROM movremark
                    WHERE mov_id = :mov_id AND barangay = :barangay_id
                ";
                $stmt = $conn->prepare($remark_query);
                $stmt->bindParam(':mov_id', $mov_row['mov_id'], PDO::PARAM_INT);
                $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
                $stmt->execute();
                $movremark_row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Return mov_id, barangay_id, PDF file URLs, rates, and remarks in the response
                echo json_encode([
                    'mov_id' => $mov_row['mov_id'],
                    'barangay_id' => $barangay_id,
                    'IA_1a_pdf_File' => $mov_row['IA_1a_pdf_File'],
                    'IA_1b_pdf_File' => $mov_row['IA_1b_pdf_File'],
                    'IA_2a_pdf_File' => $mov_row['IA_2a_pdf_File'],
                    'IA_2b_pdf_File' => $mov_row['IA_2b_pdf_File'],
                    'IA_2c_pdf_File' => $mov_row['IA_2c_pdf_File'],
                    'IA_2d_pdf_File' => $mov_row['IA_2d_pdf_File'],
                    'IA_2e_pdf_File' => $mov_row['IA_2e_pdf_File'],
                    'IB_1forcities_pdf_File' => $mov_row['IB_1forcities_pdf_File'],
                    'IB_1aformuni_pdf_File' => $mov_row['IB_1aformuni_pdf_File'],
                    'IB_1bformuni_pdf_File' => $mov_row['IB_1bformuni_pdf_File'],
                    'IB_2_pdf_File' => $mov_row['IB_2_pdf_File'],
                    'IB_3_pdf_File' => $mov_row['IB_3_pdf_File'],
                    'IB_4_pdf_File' => $mov_row['IB_4_pdf_File'],
                    'IC_1_pdf_File' => $mov_row['IC_1_pdf_File'],
                    'IC_2_pdf_File' => $mov_row['IC_2_pdf_File'],
                    'ID_1_pdf_File' => $mov_row['ID_1_pdf_File'],
                    'ID_2_pdf_File' => $mov_row['ID_2_pdf_File'],
                    'IIA_pdf_File' => $mov_row['IIA_pdf_File'],
                    'IIB_1_pdf_File' => $mov_row['IIB_1_pdf_File'],
                    'IIB_2_pdf_File' => $mov_row['IIB_2_pdf_File'],
                    'IIC_pdf_File' => $mov_row['IIC_pdf_File'],
                    'IIIA_pdf_File' => $mov_row['IIIA_pdf_File'],
                    'IIIB_pdf_File' => $mov_row['IIIB_pdf_File'],
                    'IIIC_1forcities_pdf_File' => $mov_row['IIIC_1forcities_pdf_File'],
                    'IIIC_1forcities2_pdf_File' => $mov_row['IIIC_1forcities2_pdf_File'],
                    'IIIC_1forcities3_pdf_File' => $mov_row['IIIC_1forcities3_pdf_File'],
                    'IIIC_2formuni1_pdf_File' => $mov_row['IIIC_2formuni1_pdf_File'],
                    'IIIC_2formuni2_pdf_File' => $mov_row['IIIC_2formuni2_pdf_File'],
                    'IIIC_2formuni3_pdf_File' => $mov_row['IIIC_2formuni3_pdf_File'],
                    'IIID_pdf_File' => $mov_row['IIID_pdf_File'],
                    'IV_forcities_pdf_File' => $mov_row['IV_forcities_pdf_File'],
                    'IV_muni_pdf_File' => $mov_row['IV_muni_pdf_File'],
                    'V_1_pdf_File' => $mov_row['V_1_pdf_File'],
                    'threepeoplesorg' => $mov_row['threepeoplesorg'],
                    'rates' => $movrate_row,
                    'remarks' => $movremark_row
                ]);
            } else {
                echo json_encode(['error' => 'No MOV found for this barangay']);
            }
        } else {
            echo json_encode(['error' => 'Barangay not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
}
?>
