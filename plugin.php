<?php

class PluginHeartbeat extends Plugin
{

    protected $endpoint = 'plugin-heartbeat';

    public function beforeAll()
    {
        $webhook = $this->endpoint;
        if ($this->webhook($webhook)) {
            header('Content-type: application/json');
            $login = new Login();
            echo json_encode([
                'isLoggedIn' => $login->isLogged()
            ]);
            exit(0);
        }
    }

    protected function isEditorRoute(): bool
    {
        global $url;

        $isEditorRoute = false;
        $editorRoutes = [
            DOMAIN_ADMIN . 'new-content',
            DOMAIN_ADMIN . 'edit-content'
        ];
        $currentUrl = DOMAIN . $url->uri();

        foreach ($editorRoutes as $route) {
            if (strpos($currentUrl, $route) !== false) {
                $isEditorRoute = true;
                break;
            }
        }

        return $isEditorRoute;
    }

    public function adminBodyEnd()
    {
        $html = '';
        if ($this->isEditorRoute()) {
            $html .= '<script>var heartbeatPluginEndpoint = "' . DOMAIN_BASE . $this->endpoint . '";</script>';
            $html .= $this->includeJS('plugin.js');
        }
        return $html;
    }
}
