<?
namespace api\modules\v1\auth;

use yii\filters\auth\HttpBearerAuth;
use common\models\Login;

class UserAuth extends HttpBearerAuth
{
    /**
     * @param \yii\web\User $user
     * @param \yii\web\Request $request
     * @param \yii\web\Response $response
     *
     * @return null
     *
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function authenticate($user, $request, $response)
    {
        $userModel = new Login;

        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $userModel->loginByAuthKey($user, $matches[1]);
            if ($identity === null) {
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }
}