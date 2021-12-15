<?php
namespace ModuleName\Model;

class UsersTable extends AbstractTable
{

    protected $resultsPerPage = 10;

    public function getById($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getBy(array $params = [])
    {
        $select = $this->tableGateway->getSql()->select();

        if (isset($params['id'])) {
            $select->where(['id' => $params['id']]);
            $params['limit'] = 1;
        }

        if (isset($params['property1'])) {
            $select->where(['property1' => $params['property1']]);
        }
        
        if (isset($params['property2'])) {
            $select->where(['property2' => $params['property2']]);
        }
        


        if (isset($params['limit'])) {
            $select->limit($params['limit']);
        }

        if (!isset($params['page'])) {
            $params['page'] = 0;
        }

        $result = (isset($params['limit']) && $params['limit'] == 1)
            ? $this->fetchRow($select)
            : $this->fetchAll($select, ['limit' => $this->resultsPerPage, 'page' => $params['page']]);

        return $result;
    }

    public function patch(int $id, array $data)
    {
        if (empty($data)) {
            throw new \Exception('missing data to update');
        }
        $passedData = [];

        if (!empty($data['property1'])) {
            $passedData['property1'] = $data['property1'];
        }
        
        if (!empty($data['property2'])) {
            $passedData['property2'] = $data['property2'];
        }
        

        $this->tableGateway->update($passedData, ['id' => $id]);
    }

    public function save(\ModuleName\Model\Rowset\User $rowset)
    {
        return parent::saveRow($rowset);
    }

    public function delete($id)
    {
        if (empty($id)) {
            throw new \Exception('missing UsersTable id to delete');
        }
        parent::deleteRow($id);
    }


}
