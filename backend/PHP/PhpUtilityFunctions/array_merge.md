##array_merge_recursive() vs. array_replace_recursive()

> [http://jontai.me/blog/2011/12/array_merge_recursive-vs-array_replace_recursive/](http://jontai.me/blog/2011/12/array_merge_recursive-vs-array_replace_recursive/)

###array_merge

    print_r(array_merge(
        array('a', 'b'),
        array('c', 'd')
    ));
     
    /* the above will output:
    Array
    (
        [0] => a
        [1] => b
        [2] => c
        [3] => d
    )
    */
    
    /* note that the key 'B' appears in both arrays */
    print_r(array_merge(
        array('A' => 1, 'B' => 2),
        array('B' => 20, 'C' => 30)
    ));
     
    /* the above will output:
    Array
    (
        [A] => 1
        [B] => 20
        [C] => 30
    )
    */
    
    print_r(array_merge(
        array(
            'data' => array(
                'collision' => 'first',
                'unique1' => 1,
            )
        ),
        array(
            'data' => array(
                'collision' => 'second',
                'unique2' => 2,
            )
        )
    ));
     
    /* the above will output:
    Array
    (
        [data] => Array
            (
                [collision] => second
                [unique2] => 2
            )
     
    )
    */


###array_merge_recursive

    print_r(array_merge_recursive(
        array(
            'data' => array(
                'collision' => 'first',
                'unique1' => 1,
            )
        ),
        array(
            'data' => array(
                'collision' => 'second',
                'unique2' => 2,
            )
        )
    ));
     
    /* the above will output:
    Array
    (
        [data] => Array
            (
                [collision] => Array
                    (
                        [0] => first
                        [1] => second
                    )
     
                [unique1] => 1
                [unique2] => 2
            )
     
    )
    */

###array_replace_recursive

    print_r(array_replace_recursive(
        array(
            'data' => array(
                'collision' => 'first',
                'unique1' => 1,
            )
        ),
        array(
            'data' => array(
                'collision' => 'second',
                'unique2' => 2,
            )
        )
    ));
         
    /* the above will output:
    Array
    (
        [data] => Array
            (
                [collision] => second
                [unique1] => 1
                [unique2] => 2
            )
     
    )
    */
