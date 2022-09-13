<?php

namespace App\Controller;

class CommentsController extends AppController {

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        sleep(1);
        $comments = $this->Comments->allFor($this->request->getQuery('id'), $this->request->getQuery('type'));
        $this->set(compact('comments'));
        $this->viewBuilder()->setOption('serialize', ['comments']);
    }

    public function add() {
        sleep(3);
        $data = $this->request->input('json_decode', true);
        if ($this->Comments->isCommentable($data['commentable_id'],$data['commentable_type'] )){
            $data['ip'] = $this->request->clientIp();
            $comment = $this->Comments->newEmptyEntity();
            $comment = $this->Comments->patchEntity($comment, $data);
            if ($this->Comments->save($comment)) {
                $this->set(compact('comment'));
                $this->viewBuilder()->setOption('serialize', ['comment']);
            } else {
                $this->response = $this->response->withStatus(422);
                $errors = $comment->getErrors();
                $this->set(compact('errors'));
                $this->viewBuilder()->setOption('serialize', ['errors']);
            }

        } else {
            $result = ["message" => "Contenu n'est pas commentable"];
            $this->set(compact('result'));
            $this->viewBuilder()->setOption('serialize', ['result']);
            $this->response = $this->response->withStatus(422);
        }

    }

    public function delete($id) {
        //dd($this->request->getAttribute('csrfToken'));
        //dd($id);
        $comment = $this->Comments->get($id);
        $this->Comments->delete($comment);
        $this->set('comment', $comment);
        $this->viewBuilder()->setOption('serialize', ['comment']);
    }
}
