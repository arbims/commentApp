<?php

namespace App\Controller;

use Cake\View\JsonView;

class CommentsController extends AppController {

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function index() {
        $comments = $this->Comments->allFor($this->request->getQuery('id'), $this->request->getQuery('type'));
        $this->set(compact('comments'));
        $this->viewBuilder()->setOption('serialize', ['comments']);
    }

    public function add() {
        sleep(1);
        $data = $this->request->getData();
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
        sleep(1);
        $comment = $this->Comments->get($id);
        $associated_comments = $this->Comments->find()->where(['reply' => $comment->id]);
        $this->Comments->deleteMany($associated_comments);
        $this->Comments->delete($comment);
        $this->set('comment', $comment);
        $this->viewBuilder()->setOption('serialize', ['comment']);
    }
}
