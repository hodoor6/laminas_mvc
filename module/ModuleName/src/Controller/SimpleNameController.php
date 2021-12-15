<?php
namespace ModuleName\Controller;

use \Laminas\View\Model\ViewModel;
use ModuleName\Model\SimpleNameTable;
use ModuleName\Model\Rowset\SimpleName;
use ModuleName\Form\SimpleNameForm;

class SimpleNameController extends \Laminas\Mvc\Controller\AbstractActionController
{

    protected $simpleNameTable = null;

    public function indexAction()
    {
        $view = new ViewModel();
        $rows = $this->simpleNameTable->getBy(['page' => $this->params()->fromRoute('page')]);

        $view->setVariable('simpleNameRows', $rows);

        return $view;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $simpleNameForm = new SimpleNameForm();
        $simpleNameForm->get('submit')->setValue('Add');

        if (!$request->isPost()) {
            return ['simpleNameForm' => $simpleNameForm];
        }
        $simpleNameModel = new SimpleName();
        $simpleNameForm->setInputFilter($simpleNameModel->getInputFilter());
        $simpleNameForm->setData($request->getPost());

        if (!$simpleNameForm->isValid()) {
            print_r($simpleNameForm->getMessages());
            return ['simpleNameForm' => $simpleNameForm];
        }
        $simpleNameModel->exchangeArray($simpleNameForm->getData());
        $this->simpleNameTable->save($simpleNameModel);

        $this->redirect()->toRoute('simpleName');
    }

    public function editAction()
    {
        $view = new ViewModel();
        $simpleNameId = (int) $this->params()->fromRoute('id');
        $view->setVariable('simpleNameId', $simpleNameId);
        if ($simpleNameId == 0) {
            return $this->redirect()->toRoute('simpleName', ['action' => 'add']);
        }
        // get user data; if it doesn’t exists, then redirect back to the index
        try {
            $simpleNameRow = $this->simpleNameTable->getById($simpleNameId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('simpleName', ['action' => 'index']);
        }
        $simpleNameForm = new SimpleNameForm();
        $simpleNameForm->bind($simpleNameRow);

        $simpleNameForm->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        $view->setVariable('simpleNameForm', $simpleNameForm);

        if (!$request->isPost()) {
            return $view;
        }
        $simpleNameForm->setInputFilter($simpleNameRow->getInputFilter());
        $simpleNameForm->setData($request->getPost());

        if (!$simpleNameForm->isValid()) {
            return $view;
        }
        $this->simpleNameable->save($simpleNameRow);
        // data saved, redirect to the users list page
        return $this->redirect()->toRoute('simpleName', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $simpleNameId = (int) $this->params()->fromRoute('id');

        if (empty($simpleNameId)) {
            return $this->redirect()->toRoute('simpleName');
        }
        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'Cancel');

            if ($del == 'Delete') {
                $simpleNameId = (int) $request->getPost('id');
                $this->usersTable->delete($simpleNameId);
            }
            // redirect to the users list
            return $this->redirect()->toRoute('simpleName');
        }
        return [
            'id' => $simpleNameId,
            'simpleName' => $this->simpleNameTable->getById($simpleNameId),
        ];
    }

    public function __construct(\ModuleName\Model\SimpleNameTable $simpleNameTable)
    {
        $this->simpleNameTable = $simpleNameTable;
    }


}
