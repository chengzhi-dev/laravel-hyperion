<?php

require_once('db-config.php');

class ReportBurning {
    function getAgendaItemsAndRecommendations($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $agenda_items = array();
        $stmt = $dbobject->prepare(" select * from `pa_report_agenda_items` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $agenda_items[] = $row;
        }
        $dbobject = null;
        return $agenda_items;
    }

    function getDirectorName($din_no) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select `dir_name` from `directors`  where `din_no`=:din_no");
        $stmt->bindParam(":din_no",$din_no);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $dir_name = $row['dir_name'];
        $dbobject = null;
        return $dir_name;
    }

    function getCompanyAndMeetingDetails($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `companies` INNER JOIN `pa_reports` ON `companies`.`id`=`pa_reports`.`company_id` INNER JOIN `pa_report_meeting_details` ON `pa_report_meeting_details`.`pa_reports_id`=`pa_reports`.`report_id` where `pa_reports`.`report_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $generic_details = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbobject = null;
        return $generic_details;
    }
    function companyBackgroundDate($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_market_data` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $generic_details['market_data'] = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $dbobject->prepare(" select * from `pa_report_financial_indicators` where `pa_reports_id`=:report_id order by `financial_year` DESC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['financial_indicators']=$temp;

        $stmt = $dbobject->prepare(" select * from `pa_report_peer_comparision` where `pa_reports_id`=:report_id order by `id` ASC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $peer[]=$row;
        }
        $generic_details['peer_comparision']=$peer;

        $stmt = $dbobject->prepare(" select `share_holder_name`,`share_holding`,`holder_month`,`financial_year` from `pa_report_top_public_shareholders` where `pa_reports_id`=:report_id order by `financial_year` DESC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $count_shareholders = $stmt->rowCount();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['share_holding']=$row['share_holding']."%";
            $public_share_holders[]=$row;
        }
        for($i=$count_shareholders;$i<=6;$i++) {
            $public_share_holders[]=array("share_holder_name"=>"&nbsp;","share_holding"=>"&nbsp;");
        }
        $generic_details['public_share_holders']=$public_share_holders;

        $stmt = $dbobject->prepare(" select `major_promoter_name`,`share_holding` from `pa_report_major_promoters` where `pa_reports_id`=:report_id order by `financial_year` DESC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $count_shareholders = $stmt->rowCount();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['share_holding']=$row['share_holding']."%";
            $major_promoters[]=$row;
        }
        for($i=$count_shareholders;$i<=6;$i++) {
            $major_promoters[]=array("major_promoter_name"=>"&nbsp;","share_holding"=>"&nbsp;");
        }
        $generic_details['major_promoters']=$major_promoters;

        $stmt = $dbobject->prepare(" select `companies`.`peer1`,`companies`.`peer2`, `companies`.`name`, `companies`.`bse_code` from `companies` INNER JOIN `pa_reports` ON `pa_reports`.`company_id`=`companies`.`id` where `pa_reports`.`report_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $generic_details['peer_1_company_id'] = $row['peer1'];
        $generic_details['peer_2_company_id'] = $row['peer2'];

        $stmt = $dbobject->prepare(" select * from `companies` where `id`=:peer_1_company_id");
        $stmt->bindParam(':peer_1_company_id',$generic_details['peer_1_company_id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['peer_1_company_name'] = $row['name'];

        $stmt = $dbobject->prepare(" select * from `companies` where `id`=:peer_2_company_id");
        $stmt->bindParam(':peer_2_company_id',$generic_details['peer_2_company_id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['peer_2_company_name'] = $row['name'];

        $dbobject = null;
        return $generic_details;
    }
    function companyBoardOfDirectors($report_id,$company_id,$financial_year) {
        $generic_details = array();
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_board_profile` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['board_directors'] = $temp;

        $stmt = $dbobject->prepare(" select * from `companies` where `id`=:company_id");
        $stmt->bindParam(":company_id",$company_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['company_name'] = $row['name'];


        $stmt = $dbobject->prepare(" select * from `nomination_remuneration_committee_info` where `company_id`=:company_id and `financial_year`=:financial_year");
        $stmt->bindParam(":company_id",$company_id);
        $stmt->bindParam(":financial_year",$financial_year);
        $stmt->execute();
        $row =  $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['is_rem_nom_same']=$row['are_committees_seperate']=='yes' ? 'no' : 'yes';

        $stmt = $dbobject->prepare(" select * from `pa_report_board_committee_performance` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $committee_performance[]=$row;
        }
        $generic_details['committee_performance'] = $committee_performance;
        $stmt = $dbobject->prepare(" select * from `pa_report_board_governance_score` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $board_governance_score[]=$row;
        }
        $generic_details['board_governance_score'] = $board_governance_score;

        $stmt = $dbobject->prepare(" select * from `pa_report_board_independence` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['standard_text'] = $row;

        $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `resolution_section`=:resolution_section");
        $stmt->bindParam(":report_id",$report_id);
        $resolution_name = "Committee Performance";
        $resolution_section = "Committee Performance";
        $stmt->bindParam(":resolution_name",$resolution_name);
        $stmt->bindParam(":resolution_section",$resolution_section);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['analysis_text'] = $row;

        $dbobject = null;
        return $generic_details;
    }
    function remunerationAnalysis($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_remuneration_analysis` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['remuneration_analysis']=$temp;
        $stmt = $dbobject->prepare(" select * from `pa_report_executive_remuneration_peer_comparison` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $temp=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['executive_remuneration']=$temp;

        $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `resolution_section`=:resolution_section");
        $stmt->bindParam(":report_id",$report_id);
        $resolution_name = "Remuneration Analysis";
        $resolution_section = "Remuneration Analysis";
        $stmt->bindParam(":resolution_name",$resolution_name);
        $stmt->bindParam(":resolution_section",$resolution_section);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['analysis_text_1'] = $row;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['analysis_text_2'] = $row;

        $dbobjec=null;
        return $generic_details;
    }
    function disclosures($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_disclosures` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['disclosures']=$temp;

        $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `resolution_section`=:resolution_section");
        $stmt->bindParam(":report_id",$report_id);
        $resolution_name = "Disclosure Required in Director's Report";
        $resolution_section = "Disclosure Required in Director's Report";
        $stmt->bindParam(":resolution_name",$resolution_name);
        $stmt->bindParam(":resolution_section",$resolution_section);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['analysis_text'] = $row;

        $dbobjec=null;
        return $generic_details;
    }
    function getGraphData($report_id) {
        $temp=array();
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_shareholding_patterns` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp[]=$row;
        }
        $generic_details['share_holding_patterns']=$temp;

        $stmt = $dbobject->prepare(" select * from `pa_report_variation_director_remuneration` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['variation_director_remuneration']=$row;

        $stmt = $dbobject->prepare(" select * from `pa_report_executive_remuneration_growth` where `pa_reports_id`=:report_id order by `financial_year` ASC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $remuneration_growth=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $remuneration_growth[]=$row;
        }
        $generic_details['remuneration_growth']=$remuneration_growth;

        $stmt = $dbobject->prepare(" select * from `pa_report_board_independence` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $generic_details['board_independence']=$row;

        $stmt = $dbobject->prepare(" select * from `pa_report_declaration_dividend_table1` where `pa_reports_id`=:report_id order by `financial_year` ASC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $dividend_and_earnings=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dividend_and_earnings[]=$row;
        }
        $generic_details['dividend_and_earnings']=$dividend_and_earnings;


        $stmt = $dbobject->prepare(" select * from `pa_report_declaration_dividend_table2` where `pa_reports_id`=:report_id order by `financial_year` ASC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $dividend_payout_ratio=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dividend_payout_ratio[]=$row;
        }
        $generic_details['dividend_payout_ratio']=$dividend_payout_ratio;


        $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_table1` where `pa_reports_id`=:report_id order by `financial_year` DESC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $appointment_auditors_table_1=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $appointment_auditors_table_1[]=$row;
        }
        $generic_details['appointment_auditors_table_1']=$appointment_auditors_table_1;


        // 10th graph
        $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_ed_remuneration` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $executive_compensation=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $executive_compensation[]=$row;
        }
        $generic_details['executive_compensation']=$executive_compensation;

        // 11th graph
        $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `section_name`=:section_name");
        $stmt->bindParam(":report_id",$report_id);
        $resolution_name = "Directors' Remuneration";
        $section_name = "Non-Excecutive Directors' Commission";
        $stmt->bindParam(":resolution_name",$resolution_name);
        $stmt->bindParam(":section_name",$section_name);
        $stmt->execute();
        $average_commission=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $average_commission[]=$row;
        }
        $generic_details['average_commission']=$average_commission;

        // 12th graph
        $stmt = $dbobject->prepare(" select * from `pa_report_non_executive_director_total_commission` where `pa_reports_id`=:report_id order by `year` ASC");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $director_commision=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $director_commision[]=$row;
        }
        $generic_details['director_commision']=$director_commision;

        // 13th graph
        $stmt = $dbobject->prepare(" select * from `pa_report_esop_repricing_stock_performance` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $stock_performance=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stock_performance[]=$row;
        }
        $generic_details['stock_performance']=$stock_performance;


        // 15th graph

        $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_utilisation_of_borrowing_limits` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $borrowing_limits=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $borrowing_limits[]=$row;
        }
        $generic_details['borrowing_limits']=$borrowing_limits;

        // 16th graph

        $stmt = $dbobject->prepare(" select * from `pa_report_fill_investment_limits_fii` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $fii_shareholding=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fii_shareholding[]=$row;
        }
        $generic_details['fii_shareholding']=$fii_shareholding;

        // 17th graph

        $stmt = $dbobject->prepare(" select * from `pa_report_fill_investment_limits_promoter` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $promoter_shareholding=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $promoter_shareholding[]=$row;
        }
        $generic_details['promoter_shareholding']=$promoter_shareholding;

        // 18th graph

        $stmt = $dbobject->prepare(" select * from `pa_report_donations_to_charitable_trust_csr_contributors` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $csr_contributors=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $csr_contributors[]=$row;
        }
        $generic_details['csr_contributors']=$csr_contributors;

        // 19th graph
        $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_executive_remuneration_table_2` where `pa_reports_id`=:report_id and `director_no`=:director_no");
        $stmt->bindParam(":report_id",$report_id);
        $director_no = 1;
        $stmt->bindParam(":director_no",$director_no);
        $stmt->execute();
        $executive_remuneration=array();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $executive_remuneration[]=$row;
        }
        $generic_details['executive_remuneration']=$executive_remuneration;

        $dbobject = null;
        return $generic_details;
    }
    function getIndexPageInfo($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `companies` INNER JOIN `pa_reports` ON `pa_reports`.`company_id`=`companies`.`id` INNER JOIN `pa_report_meeting_details` ON `pa_report_meeting_details`.`pa_reports_id`=`pa_reports`.`report_id` where `pa_reports`.`report_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $company_and_meeting_details =$row;
        return $company_and_meeting_details;
    }
    function adoptionOfAccount($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_other_text` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $other_text = array();
        if($stmt->rowCount()>0) {
            $generic_array['adoption_of_account_exists'] = true;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Adoption of Accounts";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_triggers` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Adoption of Accounts";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $triggers = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $triggers[]= $row;
            }
            $generic_array['triggers'] = $triggers;


            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Adoption of Accounts";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_unaudited_statements` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $unaudited_statements_table = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $unaudited_statements_table[]= $row;
            }
            $generic_array['unaudited_statements_table'] = $unaudited_statements_table;

            $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_financial_indicators` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $financial_indicators = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $financial_indicators[]= $row;
            }
            $generic_array['financial_indicators'] = $financial_indicators;

            $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_contingent_liabilities` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $contingent_liabilities = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $contingent_liabilities[]= $row;
            }
            $generic_array['contingent_liabilities'] = $contingent_liabilities;


            $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_rpt` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $adoption_of_accounts_rpt = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $adoption_of_accounts_rpt[]= $row;
            }
            $generic_array['adoption_of_accounts_rpt'] = $adoption_of_accounts_rpt;


            $stmt = $dbobject->prepare(" select `fiscal_year_end` from `companies` INNER JOIN `pa_reports` ON `companies`.`id`=`pa_reports`.`company_id` where `pa_reports`.`report_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $fiscal_month = "Mar";
            switch($row['fiscal_year_end']) {
                case 3:
                    $fiscal_month="Mar";
                    break;
                case 6:
                    $fiscal_month="Jun";
                    break;
                case 9:
                    $fiscal_month="Sept";
                    break;
                case 12:
                    $fiscal_month="Dec";
                    break;
            }
            $generic_array['fiscal_month'] = $fiscal_month;

            $stmt = $dbobject->prepare(" select * from `pa_report_adoption_of_accounts_standalone_consolidated_Acc` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $standalone_consolidated_Acc = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $standalone_consolidated_Acc[]= $row;
            }
            $generic_array['standalone_consolidated_acc'] = $standalone_consolidated_Acc;
        }
        else {
            $generic_array['adoption_of_account_exists'] = false;
        }

        return $generic_array;
    }
    function declarationOfDevidend($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_declaration_of_dividend_other_text` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $other_text = array();
        if($stmt->rowCount()>0) {
            $generic_array['declaration_of_dividend_exists'] = true;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Declaration Of Dividend";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Declaration Of Dividend";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        else {
            $generic_array['declaration_of_dividend_exists'] = false;
        }
        return $generic_array;
    }
    function esopsApprovalOfESOPScheme($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Employee Stock Options Scheme";
        $checkbox = "Approval of ESOP Scheme";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['esops_approval_ESOP_scheme_exists'] = true;
        }
        else {
            $generic_array['esops_approval_ESOP_scheme_exists'] = false;
        }
        if($generic_array['esops_approval_ESOP_scheme_exists']) {

            $section_name="Approval of ESOP Scheme";
            $stmt = $dbobject->prepare(" select * from `pa_report_employee_stock_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Employee Stock Options Scheme";
            $resolution_section = "Approval of ESOP Scheme";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Approval of ESOP Scheme";
            $resolution_name = "Employee Stock Options Scheme";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            echo $resolution_section;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
            $dbobject=null;
        }
        return $generic_array;
    }
    function esposRePricing($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Employee Stock Options Scheme";
        $checkbox = "ESOP Re-pricing";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['espos_re_pricing_exists'] = true;
        }
        else {
            $generic_array['espos_re_pricing_exists'] = false;
        }

        if($generic_array['espos_re_pricing_exists']) {

            $section_name="ESOP Re-Pricing";
            $stmt = $dbobject->prepare(" select * from `pa_report_employee_stock_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Employee Stock Options Scheme";
            $resolution_section = "ESOP Re-Pricing";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_esop_repricing_optios_being_repriced` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $optios_being_repriced = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $optios_being_repriced[]=$row;
            }
            $generic_array['optios_being_repriced'] = $optios_being_repriced;

            $resolution_section = "ESOP Re-Pricing";
            $resolution_name = "Employee Stock Options Scheme";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        $dbobject=null;
        return $generic_array;
    }
    function intercorporateLoans($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_intercorparate_other_text` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $other_text = array();
        if($stmt->rowCount()>0) {
            $generic_array['intercorporate_exists'] = true;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Intercorporate loans/guarantees/investments";
            $resolution_section = "Intercorporate loans/guarantees/investments";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_intercorporate_loans_the_recipient` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $the_recipient = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $the_recipient[]=$row;
            }
            $generic_array['the_recipient'] = $the_recipient;

            $stmt = $dbobject->prepare(" select * from `pa_report_intercorporate_loans_existing_transactions` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $existing_transactions = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $existing_transactions[]=$row;
            }
            $generic_array['existing_transactions'] = $existing_transactions;

            $resolution_section = "Intercorporate loans/guarantees/investments";
            $resolution_name = "Intercorporate loans/guarantees/investments";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        else {
            $generic_array['intercorporate_exists'] = false;
        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionStockSplit($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Stock Split";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['stock_split_exists'] = true;
        }
        else {
            $generic_array['stock_split_exists'] = false;
        }
        if($generic_array['stock_split_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Stock Split";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select `name` from `companies` INNER JOIN `pa_reports` ON `companies`.`id`=`pa_reports`.`company_id` where `pa_reports`.`report_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);;
            $generic_array['company_name']= $row['name'];

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Stock Split";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Stock Split";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionShareBuyBack($report_id){
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Share Buy-Back";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['share_buy_back_exists'] = true;
        }
        else {
            $generic_array['share_buy_back_exists'] = false;
        }

        if($generic_array['share_buy_back_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Share Buy-Back";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Share Buy-Back";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_change_in_shareholding_pattern` where `pa_reports_id`=:report_id ");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $shareholding[]=$row;
            }
            $generic_array['shareholding'] = $shareholding;

            $resolution_section = "Share Buy-Back";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;


        }
        return $generic_array;
    }
    function corporateActionSaleOfAssets($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "SALE OF ASSETS/ BUSINESS/ UNDERTAKING";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['sale_of_assets_exists'] = true;
        }
        else {
            $generic_array['sale_of_assets_exists'] = false;
        }

        if($generic_array['sale_of_assets_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "SALE OF ASSETS/ BUSINESS/ UNDERTAKING";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "SALE OF ASSETS/ BUSINESS/ UNDERTAKING";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "SALE OF ASSETS/ BUSINESS/ UNDERTAKING";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionIncreaseInBorrowingLimits($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Increase in Borrowing Limits";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['increase_borrowing_limits_exists'] = true;
        }
        else {
            $generic_array['increase_borrowing_limits_exists'] = false;
        }

        if($generic_array['increase_borrowing_limits_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Increase in Borrowing Limits";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Increase in Borrowing Limits";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Increase in Borrowing Limits";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionCapitalReduction($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Capital Reduction";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['capital_reduction_exists'] = true;
        }
        else {
            $generic_array['capital_reduction_exists'] = false;
        }

        if($generic_array['capital_reduction_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Capital Reduction";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Capital Reduction";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Capital Reduction";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionDebtRestructuring($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Debt Restructuring";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['debt_restructuring_exists'] = true;
        }
        else {
            $generic_array['debt_restructuring_exists'] = false;
        }

        if($generic_array['debt_restructuring_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Debt Restructuring";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Debt Restructuring";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Debt Restructuring";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionVariationIPO($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Variation in terms of use of IPO proceeds";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['variation_ipo_exists'] = true;
        }
        else {
            $generic_array['variation_ipo_exists'] = false;
        }

        if($generic_array['variation_ipo_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Variation in terms of use of IPO proceeds";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Variation in terms of use of IPO proceeds";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Variation in terms of use of IPO proceeds";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function corporateActionCreationOfCharge($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Corporate Action";
        $checkbox = "Creation of charge";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['creation_of_charge_exists'] = true;
        }
        else {
            $generic_array['creation_of_charge_exists'] = false;
        }

        if($generic_array['creation_of_charge_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_corporate_action_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Creation of charge";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Corporate Action";
            $resolution_section = "Creation of charge";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Creation of charge";
            $resolution_name = "Corporate Action";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        $dbobject=null;
        return $generic_array;
    }
    function alterationMoaAoaChangeInObjectsClause($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Change in Objects Clause";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['change_in_object_clause_exists'] = true;
        }
        else {
            $generic_array['change_in_object_clause_exists'] = false;
        }

        if($generic_array['change_in_object_clause_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Change in Objects Clause";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Change in Objects Clause";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Change in Objects Clause";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaChangeInQuorumRequirements($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Change in Quorum Requirements";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['change_in_quorum_requirements_exists'] = true;
        }
        else {
            $generic_array['change_in_quorum_requirements_exists'] = false;
        }

        if($generic_array['change_in_quorum_requirements_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Change in Quorum Requirements";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Change in Quorum Requirements";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Change in Quorum Requirements";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaChangeInNameCompany($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Change in name of the Company";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['change_in_name_of_the_company_exists'] = true;
        }
        else {
            $generic_array['change_in_name_of_the_company_exists'] = false;
        }

        if($generic_array['change_in_name_of_the_company_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Change in name of the Company";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Change in name of the Company";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Change in name of the Company";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaChangeInRegisteredOffice($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Change in Registered office of the Company";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['change_in_registered_office_company_exists'] = true;
        }
        else {
            $generic_array['change_in_registered_office_company_exists'] = false;
        }

        if($generic_array['change_in_registered_office_company_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Change in Registered office of the Company";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Change in Registered office of the Company";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Change in Registered office of the Company";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaChangeInAuthorizedCapital($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Change in Authorized Capital";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['change_in_authorized_capital_exists'] = true;
        }
        else {
            $generic_array['change_in_authorized_capital_exists'] = false;
        }

        if($generic_array['change_in_authorized_capital_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Change in Authorized Capital";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Change in Authorized Capital";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Change in Authorized Capital";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaIncreaseInBoardStrength($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Increase in Board Strength";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['increase_in_board_strength_exists'] = true;
        }
        else {
            $generic_array['increase_in_board_strength_exists'] = false;
        }

        if($generic_array['increase_in_board_strength_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Increase in Board Strength";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Increase in Board Strength";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Increase in Board Strength";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaChangesDueToShareholdersAgreements($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Changes due to shareholders' Agreements";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['changes_shareholders_agreements_exists'] = true;
        }
        else {
            $generic_array['changes_shareholders_agreements_exists'] = false;
        }

        if($generic_array['changes_shareholders_agreements_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Changes due to shareholders' Agreements";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Changes due to shareholders' Agreements";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Changes due to shareholders' Agreements";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function alterationMoaAoaRemovalOfClauses($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Alteration in MOA / AOA";
        $checkbox = "Removal of clauses due to termination of shareholders' Agreement";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['removal_clauses_termination_of_shareholders_agreement_exists'] = true;
        }
        else {
            $generic_array['removal_clauses_termination_of_shareholders_agreement_exists'] = false;
        }

        if($generic_array['removal_clauses_termination_of_shareholders_agreement_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_alteration_moa_aoa_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Removal of clauses due to termination of shareholders' Agreement";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Alteration in MOA / AOA";
            $resolution_section = "Removal of clauses due to termination of shareholders' Agreement";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Removal of clauses due to termination of shareholders' Agreement";
            $resolution_name = "Alteration in MOA / AOA";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesRightsIssue($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Rights Issue/Public Issue";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['rights_issue_public_issue_exists'] = true;
        }
        else {
            $generic_array['rights_issue_public_issue_exists'] = false;
        }

        if($generic_array['rights_issue_public_issue_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Rights Issue/Public Issue";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Rights Issue/Public Issue";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Rights Issue/Public Issue";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesPreferentialIssue($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Preferential Issue";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['preferential_issue_exists'] = true;
        }
        else {
            $generic_array['preferential_issue_exists'] = false;
        }

        if($generic_array['preferential_issue_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Preferential Issue";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Preferential Issue";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_preferential_issue_past_equity_issue` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $equity_row = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $equity_row[]=$row;
            }
            $generic_array['equity_row'] = $equity_row;

            $stmt = $dbobject->prepare(" select * from `pa_report_preferential_issue_dilution_to_shareholding` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $dilution_to_shareholding = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $dilution_to_shareholding[]=$row;
            }
            $generic_array['dilution_to_shareholding'] = $dilution_to_shareholding;


            $resolution_section = "Preferential Issue";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesBonusIssue($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Bonus Issue";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['bonus_issue_exists'] = true;
        }
        else {
            $generic_array['bonus_issue_exists'] = false;
        }

        if($generic_array['bonus_issue_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Bonus Issue";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Bonus Issue";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Bonus Issue";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesIssueOfSecuritiesToPublic($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Issue of Securities to Public";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['issue_of_securities_to_public_exists'] = true;
        }
        else {
            $generic_array['issue_of_securities_to_public_exists'] = false;
        }

        if($generic_array['issue_of_securities_to_public_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Issue of Securities to Public";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Issue of Securities to Public";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $stmt = $dbobject->prepare(" select * from `pa_report_issue_of_securities_dilution_to_shareholding` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $dilution_to_shareholding = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $dilution_to_shareholding[]=$row;
            }
            $generic_array['dilution_to_shareholding'] = $dilution_to_shareholding;


            $resolution_section = "Issue of Securities to Public";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesIssueOfPreferenceShares($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Issue of preference shares";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['issue_of_preference_shares_exists'] = true;
        }
        else {
            $generic_array['issue_of_preference_shares_exists'] = false;
        }

        if($generic_array['issue_of_preference_shares_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Issue of preference shares";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Issue of preference shares";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Issue of preference shares";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function issuesOfSharesIssueOfSharesWithDifferentialVotingRights($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Issue of Shares";
        $checkbox = "Issue of shares with differential voting Rights";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['issue_of_shares_with_differential_voting_rights_exists'] = true;
        }

        else {
            $generic_array['issue_of_shares_with_differential_voting_rights_exists'] = false;
        }

        if($generic_array['issue_of_shares_with_differential_voting_rights_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_issues_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Issue of shares with differential voting Rights";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Issue of Shares";
            $resolution_section = "Issue of shares with differential voting Rights";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;


            $resolution_section = "Issue of shares with differential voting Rights";
            $resolution_name = "Issue of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function appointmentOfAuditorsAppointmentOfAuditorsAtBanks($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Appointment of Auditors At Banks";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['appointment_auditors_banks_exists'] = true;
        }
        else {
            $generic_array['appointment_auditors_banks_exists'] = false;
        }

        if($generic_array['appointment_auditors_banks_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment of Auditors At Banks";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors At Banks";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors At Banks";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function appointmentOfAuditorsAppointmentOfAuditorsAtPSU($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Appointment of Auditors at PSU";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['appointment_auditors_psu_exists'] = true;
        }
        else {
            $generic_array['appointment_auditors_psu_exists'] = false;
        }

        if($generic_array['appointment_auditors_psu_exists']) {
            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment of Auditors at PSU";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors at PSU";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors at PSU";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function appointmentOfAuditorsAppointmentOfBranchAuditors($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Appointment of Branch Auditors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['appointment_branch_auditors_exists'] = true;
        }
        else {
            $generic_array['appointment_branch_auditors_exists'] = false;
        }

        if($generic_array['appointment_branch_auditors_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment of Branch Auditors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Branch Auditors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Branch Auditors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function appointmentOfAppointmentPaymentToCostAuditors($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Payment to Cost Auditors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['payment_to_cost_auditors_exists'] = true;
        }
        else {
            $generic_array['payment_to_cost_auditors_exists'] = false;
        }
        if($generic_array['payment_to_cost_auditors_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Payment to Cost Auditors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Payment to Cost Auditors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Payment to Cost Auditors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;

    }
    function appointmentOfAppointmentRemovalOfAuditors($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Removal of Auditors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['removal_of_auditors_exists'] = true;
        }
        else {
            $generic_array['removal_of_auditors_exists'] = false;
        }
        if($generic_array['removal_of_auditors_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Removal of Auditors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Removal of Auditors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Removal of Auditors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function appointmentOfAppointmentAppointmentOfAuditors($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Auditors";
        $checkbox = "Appointment of Auditors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['appointment_of_auditors_exists'] = true;
        }
        else {
            $generic_array['appointment_of_auditors_exists'] = false;
        }
        if($generic_array['appointment_of_auditors_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_of_auditors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment of Auditors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_triggers` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_section = "Appointment of Auditors";
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $triggers = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $triggers[]= $row;
            }
            $generic_array['triggers'] = $triggers;

            $resolution_name = "Appointment of Auditors";
            $resolution_section = "Appointment of Auditors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function relatedPartyTransaction($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_related_part_transaction_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
        $stmt->bindParam(":report_id",$report_id);
        $section_name = "Related Party Transactions";
        $stmt->bindParam(":section_name",$section_name);
        $stmt->execute();
        $other_text = array();
        $generic_array['related_party_transaction_exists'] = false;
        if($stmt->rowCount()>0) {
            $generic_array['related_party_transaction_exists'] = true;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
        }

        if($generic_array['related_party_transaction_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Related Party Transactions";
            $resolution_section = "Related Party Transactions";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_related_party_transaction_table1` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $table_1 = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $table_1[]= $row;
            }
            $generic_array['table_1'] = $table_1;

            $stmt = $dbobject->prepare(" select * from `pa_report_related_party_transaction_table2` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $table_2 = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $table_2[]= $row;
            }
            $generic_array['table_2'] = $table_2;

            $resolution_name = "Related Party Transactions";
            $resolution_section = "Related Party Transactions";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function appointmentOfDirectorsED($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare("select * from `pa_report_appointed_directors` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $generic_array['no_of_executive'] = $row['no_of_ed'];

        $company_id = $_SESSION['company_id'];
        $financial_year = $_SESSION['report_year'];
        $stmt = $dbobject->prepare("select * from `nomination_remuneration_committee_info` where `company_id`=:company_id and `financial_year`=:financial_year");
        $stmt->bindParam(":company_id",$company_id);
        $stmt->bindParam(":financial_year",$financial_year);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $generic_array['are_committees_seperate'] = $row['are_committees_seperate'];

        if($generic_array['no_of_executive'] > 0) {

            $generic_array['appointment_of_executive_directors_exists']= true;
            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name ORDER BY `director_no` ASC ");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment/Reappointment of Executive Directors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Executive Directors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $recommendation_text[] = $row;
            }
            $generic_array['recommendation_text'] = $recommendation_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_past_remuneration` where `pa_reports_id`=:report_id ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $past_remuneration = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $past_remuneration[]=$row;
            }
            $generic_array['past_remuneration'] = $past_remuneration;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_executive_remuneration_p_c` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $peer_comparison = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $peer_comparison[]=$row;
            }
            $generic_array['peer_comparison'] = $peer_comparison;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_rem_package` where `pa_reports_id`=:report_id ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $rem_package = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $rem_package[]=$row;
            }
            $generic_array['rem_package'] = $rem_package;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Executive Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->execute();
            $analysis_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[] = $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        else{
            $generic_array['appointment_of_executive_directors_exists'] = false;
        }
        return($generic_array);
    }
    function appointmentOfDirectorsID($report_id){
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare("select * from `pa_report_appointed_directors` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $generic_array['no_of_independent'] = $row['no_of_id'];
        if($generic_array['no_of_independent'] > 0) {
            $generic_array['appointment_of_independent_directors_exists']= true;
            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Appointment/Reappointment of Independent Directors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            //echo "No of rows: ".$stmt->rowCount();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Independent Directors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $recommendation_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $recommendation_text[]=$row;
            }
            $generic_array['recommendation_text'] = $recommendation_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Independent Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->execute();
            $analysis_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[] = $row;
            }
            $generic_array['analysis_text'] = $analysis_text;


        }
        else{
            $generic_array['appointment_of_independent_directors_exists'] = false;
        }
        return $generic_array;
    }
    function appointmentOfDirectorsNED($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare("select * from `pa_report_appointed_directors` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $generic_array['no_of_non_executive'] = $row['no_of_ned'];
        //echo $generic_array['no_of_non_executive'];
        if($generic_array['no_of_non_executive'] > 0) {
            $generic_array['appointment_of_non_executive_directors_exists'] = true;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name ORDER BY `director_no` ASC");
            $stmt->bindParam(":report_id", $report_id);
            $section_name = "Appointment/Reappointment of Non-Executive Directors";
            $stmt->bindParam(":section_name", $section_name);
            $stmt->execute();
            $other_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[] = $row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Non-Executive Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->execute();
            $recommendation = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $recommendation[] = $row;
            }
            $generic_array['recommendation_text'] = $recommendation;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Appointment/Reappointment of Non-Executive Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->execute();
            $analysis_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[] = $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        else{
            $generic_array['appointment_of_non_executive_directors_exists'] = false;
            // echo "false";
        }
        return $generic_array;
    }
    function appointmentOfDirectorsCessationDirectorship($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Directors";
        $checkbox = "Cessation of Directorship";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['cessation_directorship'] = true;
        }
        else {
            $generic_array['cessation_directorship'] = false;
        }
        if($generic_array['cessation_directorship']) {

            $slot_no = 1;
            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $section_name = "Cessation of Directorship";
            $stmt->bindParam(":section_name", $section_name);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $other_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[] = $row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare("select * from `pa_report_appointment_directors_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `resolution_section`=:resolution_section and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Cessation of Directorship";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $recommendation = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $recommendation[] = $row;
            }
            $generic_array['recommendation_text'] = $recommendation;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Cessation of Directorship";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $analysis_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[] = $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function appointmentOfDirectorsAlternateDirectors($report_id) {
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);
        $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Appointment of Directors";
        $checkbox = "Alternate Directors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['alternate_directors'] = true;
        }
        else {
            $generic_array['alternate_directors'] = false;
        }
        if($generic_array['alternate_directors']) {

            $slot_no = 1;
            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $section_name = "Alternate Directors";
            $stmt->bindParam(":section_name", $section_name);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $other_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[] = $row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare("select * from `pa_report_appointment_directors_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and `resolution_section`=:resolution_section and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Alternate Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $recommendation = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $recommendation[] = $row;
            }
            $generic_array['recommendation_text'] = $recommendation;

            $stmt = $dbobject->prepare(" select * from `pa_report_appointment_directors_analysis_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section and `director_no`=:slot_no");
            $stmt->bindParam(":report_id", $report_id);
            $resolution_name = "Appointment Of Directors";
            $resolution_section = "Alternate Directors";
            $stmt->bindParam(":resolution_name", $resolution_name);
            $stmt->bindParam(":resolution_section", $resolution_section);
            $stmt->bindParam(":slot_no", $slot_no);
            $stmt->execute();
            $analysis_text = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[] = $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function directorsRemunerationREDR($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Directors' Remuneration";
        $checkbox = "Revision in Executive Directors' Remuneration";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['non_executive_commision_exists'] = true;
        }
        else {
            $generic_array['non_executive_commision_exists'] = false;
        }
        if($generic_array['non_executive_commision_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Revision in Executive Directors' Remuneration";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Revision in Executive Directors' Remuneration";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_revision_in_executive_past_remuneration` INNER JOIN `directors` ON `directors`.`din_no`=`pa_report_revision_in_executive_past_remuneration`.`executive_director` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $past_remuneration = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $past_remuneration[]=$row;
            }
            $generic_array['past_remuneration'] = $past_remuneration;

            $stmt = $dbobject->prepare(" select * from `pa_report_revision_in_executive_peer_comparsion`  where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $peer_comparison = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $peer_comparison[]=$row;
            }
            $generic_array['peer_comparison'] = $peer_comparison;

            $stmt = $dbobject->prepare(" select `dir_name` from `directors`  where `din_no`=:din_no");
            $stmt->bindParam(":din_no",$peer_comparison[0]['peer1']);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['com_dir_name'] = $row['dir_name'];


            $stmt = $dbobject->prepare(" select * from `pa_report_revision_in_executive_remuneration_package` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            $remuneration_package = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $remuneration_package[]=$row;
            }
            $generic_array['remuneration_package'] = $remuneration_package;


            $resolution_section = "Revision in Executive Directors' Remuneration";
            $resolution_name = "Directors' Remuneration";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function directorsRemunerationNEDC($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Directors' Remuneration";
        $checkbox = "Non-Executive Directors' Commission";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['non_executive_directors_commission_exists'] = true;
        }
        else {
            $generic_array['non_executive_directors_commission_exists'] = false;
        }
        if($generic_array['non_executive_directors_commission_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Non-Excecutive Directors' Commission";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Non-Excecutive Directors' Commission";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Non-Excecutive Directors' Commission";
            $resolution_name = "Directors' Remuneration";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;

        }
        return $generic_array;
    }
    function directorsRemunerationRNINED($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Directors' Remuneration";
        $checkbox = "Remuneration to Non-Independent Non-Executive Directors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['remuneration_non_independent_exists'] = true;
        }
        else {
            $generic_array['remuneration_non_independent_exists'] = false;
        }

        if($generic_array['remuneration_non_independent_exists']) {
            $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Remuneration to Non-Independent Non-Executive Directors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            echo "No of rows: ".$stmt->rowCount();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Remuneration to Non-Independent Non-Executive Directors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Remuneration to Non-Independent Non-Executive Directors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;


        }
        return $generic_array;
    }
    function directorsRemunerationRID($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Directors' Remuneration";
        $checkbox = "Remuneration to Independent Directors";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['remuneration_independent_exists'] = true;
        }
        else {
            $generic_array['remuneration_independent_exists'] = false;
        }
        if($generic_array['remuneration_independent_exists']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Remuneration Independent Directors";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            echo "No of rows: ".$stmt->rowCount();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }

            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Remuneration Independent Directors";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Remuneration to Non-Independent Non-Executive Directors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        return $generic_array;
    }
    function directorsRemunerationWER($report_id) {

        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_checkbox` where `pa_reports_id`=:report_id and `main_section`=:main_section and `checkbox`=:checkbox");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Directors' Remuneration";
        $checkbox = "Waiver of Excess Remuneration";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->bindParam(":checkbox",$checkbox);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $generic_array['waiver_excess_remuneration_exists'] = true;
        }
        else {
            $generic_array['waiver_excess_remuneration_exists'] = false;
        }

        if($generic_array['waiver_excess_remuneration_exists']) {
            $stmt = $dbobject->prepare(" select * from `pa_report_director_remuneration_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Waiver of Excess Remuneration";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            echo "No of rows: ".$stmt->rowCount();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }

            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Waiver of Excess Remuneration";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_name = "Directors' Remuneration";
            $resolution_section = "Remuneration to Non-Independent Non-Executive Directors";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }

        return $generic_array;
    }
    function schemeOfArrangement($report_id){
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_scheme_of_arrangement_other_text` where `pa_reports_id`=:report_id");
        $stmt->bindParam(":report_id",$report_id);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;
            $generic_array['scheme_arrangement_exists'] = true;
            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "SCHEME OF ARRANGEMENT/AMALGAMATION";
            $resolution_section = "SCHEME OF ARRANGEMENT/AMALGAMATION";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $stmt = $dbobject->prepare(" select * from `pa_report_scheme_of_arrangement_profiles_of_the_companies` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            // echo $stmt->rowCount();
            $profiles = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $profiles[]=$row;
            }
            $generic_array['profiles'] = $profiles;

            $stmt = $dbobject->prepare(" select * from `pa_report_scheme_of_arrangement_share_holding` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            // echo $stmt->rowCount();
            $pattern = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $pattern[]=$row;
            }
            $generic_array['pattern'] = $pattern;

            $stmt = $dbobject->prepare(" select * from `pa_report_scheme_of_arrangement_capital_structure` where `pa_reports_id`=:report_id");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->execute();
            // echo $stmt->rowCount();
            $capital = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $capital[]=$row;
            }
            $generic_array['capital'] = $capital;

            $resolution_section = "SCHEME OF ARRANGEMENT/AMALGAMATION ";
            $resolution_name = "SCHEME OF ARRANGEMENT/AMALGAMATION ";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }
        else {
            $generic_array['scheme_arrangement_exists'] = false;
        }

        $dbobject=null;
        return $generic_array;
    }
    function fillInvestmentLimits($report_id){
        echo $report_id;
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_fill_investment_limits_other_text` where `pa_reports_id`=:report_id and `resolution_name`=:main_section");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Fill Investment Limits";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['fill_investment_limits_exist'] = true;
        }
        else {
            $generic_array['fill_investment_limits_exist'] = false;
        }


        if($generic_array['fill_investment_limits_exist']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_fill_investment_limits_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Fill Investment Limits";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Fill Investment Limits";
            $resolution_section = "Fill Investment Limits";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Fill Investment Limits";
            $resolution_name = "Fill Investment Limits";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }

        return $generic_array;
    }
    function delistingOfShares($report_id){
        echo $report_id;
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_delisting_of_shares_other_text` where `pa_reports_id`=:report_id and `resolution_name`=:main_section");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Delisting of Shares";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['delisting_of_shares_exist'] = true;
        }
        else {
            $generic_array['delisting_of_shares_exist'] = false;
        }


        if($generic_array['delisting_of_shares_exist']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_delisting_of_shares_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Delisting of Shares";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Delisting of Shares";
            $resolution_section = "Delisting of Shares";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Delisting of Shares";
            $resolution_name = "Delisting of Shares";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }

        return $generic_array;
    }
    function donationsToCharitableTrust($report_id){
        echo $report_id;
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_donations_to_charitable_trust_other_text` where `pa_reports_id`=:report_id and `resolution_name`=:main_section");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Donations to Charitable Trusts";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['donation_to_charitable_trusts_exist'] = true;
        }
        else {
            $generic_array['donation_to_charitable_trusts_exist'] = false;
        }


        if($generic_array['donation_to_charitable_trusts_exist']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_donations_to_charitable_trust_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Donations to Charitable Trusts";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Donations to Charitable Trusts";
            $resolution_section = "Donations to Charitable Trusts";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Donations to Charitable Trusts";
            $resolution_name = "Donations to Charitable Trusts";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }

        return $generic_array;
    }
    function officeOfProfit($report_id){
        echo $report_id;
        $dbobject = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWORD);

        $stmt = $dbobject->prepare(" select * from `pa_report_office_of_profit_other_text` where `pa_reports_id`=:report_id and `resolution_name`=:main_section");
        $stmt->bindParam(":report_id",$report_id);
        $main_section = "Office of Profit";
        $stmt->bindParam(":main_section",$main_section);
        $stmt->execute();

        if($stmt->rowCount()>0) {
            $generic_array['office_of_profit_exist'] = true;
        }
        else {
            $generic_array['office_of_profit_exist'] = false;
        }

        if($generic_array['office_of_profit_exist']) {

            $stmt = $dbobject->prepare(" select * from `pa_report_office_of_profit_other_text` where `pa_reports_id`=:report_id and `section_name`=:section_name");
            $stmt->bindParam(":report_id",$report_id);
            $section_name = "Office of Profit";
            $stmt->bindParam(":section_name",$section_name);
            $stmt->execute();
            $other_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $other_text[]=$row;
            }
            $generic_array['other_text'] = $other_text;

            $stmt = $dbobject->prepare(" select * from `pa_report_recommendations_text` where `pa_reports_id`=:report_id and `resolution_name`=:resolution_name and  `resolution_section`=:resolution_section");
            $stmt->bindParam(":report_id",$report_id);
            $resolution_name = "Office of Profit";
            $resolution_section = "Office of Profit";
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $generic_array['recommendation_text'] = $row;

            $resolution_section = "Office of Profit";
            $resolution_name = "Office of Profit";
            $stmt = $dbobject->prepare(" select * from `pa_report_analysis_text` where `pa_reports_id`=:report_id and `resolution_section`=:resolution_section and `resolution_name`=:resolution_name");
            $stmt->bindParam(":report_id",$report_id);
            $stmt->bindParam(":resolution_section",$resolution_section);
            $stmt->bindParam(":resolution_name",$resolution_name);
            $stmt->execute();
            $analysis_text = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $analysis_text[]= $row;
            }
            $generic_array['analysis_text'] = $analysis_text;
        }

        return $generic_array;
    }
}
?>