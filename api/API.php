<?php

    namespace nirot1r;
    class API {

        private static $sqli;

        /* コンストラクタ */
            function __construct()
            {
                if(!($sqli = self::connectMySQL())) {
                    throw new \Exception("MySQL Connection Error");
                } else {
                    self::$sqli = $sqli;
                }
            }

        /* スコアリスト取得 */
            function getScoreList()
            {
                if($result = self::$sqli->query("SELECT * FROM scores WHERE 1")) {
                    $count = $result->num_rows;
                    $data = [];
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row["scoreID"];
                    }
                }
                return $data;
                /* return: Array(Int scoreID) */
            }
        /* スコア情報取得 */
            function loadScoreInfo($_ID)
            {
                if($stmt = self::$sqli->prepare("SELECT * FROM scores WHERE scoreID = ?"))
                {
                    $stmt->bind_param("i", $_ID);
                    $stmt->execute();

                    $stmt->bind_result($scoreID, $scoreName, $scoreInitial, $scoreKana, $schoolID);
                    $data = [];
                    while ($stmt->fetch())
                    {
                        $data = [
                            "scoreID" => $scoreID,
                            "scoreName" => $scoreName,
                            "scoreInitial" => $scoreInitial,
                            "scoreKana" => $scoreKana,
                            "schoolID" => $schoolID
                        ];
                    }
                }
                $stmt->close();
                return $data;
                /* return: Object Score */
            }
        /* スコア情報作成 */
            function createScore()
            {
                /* return: Boolean */
            }

        /* ログ取得 */
            function loadLog($scoreID)
            {
                /* return: $classID, $userID, timestamp */
            }
        /* ログ書き込み */
            function writeLog($scoreID, $classID, $userID)
            {
                /* return: void */
            }

        /* 管理団体情報取得 */
            function getSchool()
            {
                /* return: Object School  */
            }

        /* ユーザ情報取得 */
            function getUserInfo($userID)
            {
                /* return: Object User */
            }

        /* データベース接続 */
            function connectMySQL()
            {
                $sqli = new \mysqli("localhost", "ukwo", "", "ukwo_score_manage");
                if ($error = $sqli->connect_error) {
                    return null;
                } else {
                    $sqli->set_charset("utf8mb4");
                }
                return $sqli;
                /* return: MySQLi Object */
            }
    }

    $API = new API();
    foreach($API::getScoreList() as $item)
    {
        print_r($API::loadScoreInfo($item));
    }
?>