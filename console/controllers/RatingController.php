<?
namespace console\controllers;

use common\models\CountryRating;
use Yii;

class RatingController
{
    public function actionIndex()
    {
        Yii::$app->db->createCommand()->truncateTable(CountryRating::tableName());

        $sql = '
        INSERT INTO
          ' . CountryRating::tableName() . '
        SELECT
          `BX-Book-Ratings`.`Book-ID`, `BX-Users`.`Country`,
          SUM(`BX-Book-Ratings`.`Book-Rating`) / COUNT(`BX-Book-Ratings`.`Book-Rating`)
        FROM
          `BX-Book-Ratings`
            LEFT JOIN
          `BX-Users` ON (`BX-Book-Ratings`.`User-ID` = `BX-Users`.`User-ID`)
        WHERE
          `BX-Users`.`Country` != ""
            AND
          `BX-Users`.`Country` != \'"n/a"\'
        GROUP BY
          `BX-Book-Ratings`.`Book-ID`, `BX-Users`.`Country`';
        Yii::$app->db->createCommand($sql)->execute();
    }
}