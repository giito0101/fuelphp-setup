<?php
use Fuel\Core\Response;
use Fuel\Core\Format;
use Fuel\Core\Controller;

class Controller_Skills extends Controller
{
    private $skills = array(
        array(
            'id' => 1,
            'name' => 'PHP',
            'level' => 'beginner',
        ),
        array(
            'id' => 2,
            'name' => 'FuelPHP',
            'level' => 'learning',
        ),
    );

    public function action_index()
    {
        return $this->json_response($this->skills);
    }

    public function action_view($id)
    {
        foreach ($this->skills as $skill)
        {
            if ($skill['id'] === (int) $id)
            {
                return $this->json_response($skill);
            }
        }

        return $this->json_response(array('error' => 'Skill not found'), 404);
    }

    private function json_response($data, $status = 200)
    {
        return Response::forge(
            Format::forge($data)->to_json(),
            $status,
            array('Content-Type' => 'application/json')
        );
    }
}
