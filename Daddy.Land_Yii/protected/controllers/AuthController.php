<?php
/**
 * Description of AuthController
 *
 * @author ako
 */
class AuthController extends Controller {
    protected $client_id = '4328323';
    protected $client_secret = 'f7Tqu9fo48hclwVEEaFz';
    protected $redirect_uri = "/auth/vklogin";
    protected $url = 'http://oauth.vk.com/authorize';
    
    public function actionIndex() {
        
    }
    
    public function actionLogout() {
        unset(Yii::app()->session['uid']);
        $this->redirect("/");
    }
    
    public function actionVklogin($code) {
        $result = false;
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'redirect_uri' => Yii::app()->getBaseUrl(true).$this->redirect_uri
        );

        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

        if (isset($token['access_token'])) {
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,screen_name,nickname,photo_200',
                'access_token' => $token['access_token']
            );

            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
            if (isset($userInfo['response'][0]['uid'])) {
                $userInfo = $userInfo['response'][0];
                $result = true;
            }
        }
        if($result) {
            $save = false;
            $user = User::model()->find('vkid=:vkid', array('vkid'=>$userInfo['uid']));
            if($user===null) {
                $save = true;
                $user = new User;
                $user->vkid = $userInfo['uid'];
            }
            $user->avatar = $userInfo['photo_200'];
            $user->vkuri = $userInfo['screen_name'];
            $user->nickname = empty($userInfo['nickname']) ? ($userInfo['first_name']." ".$userInfo['last_name']) : $userInfo['nickname'];
            
            $save ? $user->save() : $user->update();
            Yii::app()->session['uid'] = $user->id;
            $this->redirect("/login/success");
        } else {
            $this->redirect("/login/error");
        }
    }
    
    public function getVKAuthLink() {
        $params = array(
            'client_id'     => $this->client_id,
            'redirect_uri'  => Yii::app()->getBaseUrl(true).$this->redirect_uri,
            'response_type' => 'code'
        );
        return $this->url . '?' . urldecode(http_build_query($params));
    }
}
