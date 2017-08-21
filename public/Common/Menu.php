<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 13.08.2017
 * Time: 20:40
 */

namespace Common;


class Menu
{

    protected static $length = [];

    public function getTree ($linear)
    {

        $simple_tree = [];
        $tree = [];
        foreach ($linear as $number => $data_db)
        {

                if (!is_null($data_db[2]))
                {
                    $simple_tree[$data_db[0]] = $data_db[2];
                }
                else
                {
                    $tree[$number] = [];
                }
        }
        //var_dump($simple_tree);
        //var_dump($tree);

        $arr_t = array_keys($tree);
        $arr_s = array_intersect($simple_tree,$arr_t);
        asort($arr_s);
        asort($arr_t);
        //var_dump($arr_t);

        $length = $this->getLengthsArrays($arr_t,$arr_s);

        //f(mas) => mas
        $tree = $this->collectArrayByKey($length,$arr_s,$tree);


//==========================================================
        $arr_t2 = array_keys($arr_s);
        $arr_s2 = array_intersect($simple_tree,$arr_t2);
        asort($arr_s2);
        asort($arr_t2);

        //f(mas1,mas2)
        $length2 = $this->getLengthsArrays($arr_t2,$arr_s2);


        $arr_s = $this->collectArrayByKey($length2,$arr_s2,$arr_s);

        foreach ($arr_s as $key2 => $item2)
        {
            foreach ($tree as $key_1 => $item_1)
            {
                if (!empty($item_1))
                {
                    foreach ($item_1 as $key_2 => $item_2)
                    {
                        if ($key2 === $key_2)
                        {
                            if (is_array($arr_s[$key_2]))
                            {
                                $tree[$key_1][$key_2] = $item2;
                            }
                            else
                            {

                            }
                        }

                    }
                }
                else
                {

                }
            }
        }

        //if (!is_array($arr)) || (empty($arr))
        //var_dump($arr_s);
        //var_dump($arr_t2);
        //var_dump($length);
        return $tree;
    }

    protected function getLengthsArrays ($arr_t,$arr_s)
    {
        $length = self::$length;
        foreach ($arr_t as $key_t)
        {
            $i = 0;
            foreach ($arr_s as $key_s)
            {
                if ($key_s == $key_t)
                {
                    $i++;
                }
            }
            $length[$key_t] = $i;
        }
        return $length;
    }

    protected function collectArrayByKey ($length,$arr_s,$tree_previous_keys)
    {
        $j = 0;
        foreach ($length as $key_t => $i)
        {
            if ($i !== 0) {
                $slice_mas = array_slice($arr_s, $j, $i, true);
                $tree_previous_keys[$key_t] = $slice_mas;
                $j += $i;
            }
        }
        return $tree_previous_keys;
    }
}































