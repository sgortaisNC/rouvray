<?php

namespace Drupal\nc_social;

/**
 * Class NcSocialStorage.
 */
class NcSocialStorage {

  /**
   * Save an entry in the database.
   *
   * The underlying DBTNG function is db_insert().
   *
   * Exception handling is shown in this example. It could be simplified
   * without the try/catch blocks, but since an insert will throw an exception
   * and terminate your application if the exception is not handled, it is best
   * to employ try/catch.
   *
   * @param array $entry
   *   An array containing all the fields of the database record.
   *
   * @return int
   *   The number of updated rows.
   *
   * @throws \Exception
   *   When the database insert fails.
   *
   * @see db_insert()
   */
  public static function insert($entry) {
    $return_value = NULL;
    try {
      $return_value = db_insert('nc_social')
        ->fields($entry)
        ->execute();
    }
    catch (\Exception $e) {
      drupal_set_message(t('db_insert failed. Message = %message, query= %query', array(
          '%message' => $e->getMessage(),
          '%query' => $e->query_string,
        )
      ), 'error');
    }
    return $return_value;
  }

  /**
   * Update an entry in the database.
   *
   * @param array $entry
   *   An array containing all the fields of the item to be updated.
   *
   * @return int
   *   The number of updated rows.
   *
   * @see db_update()
   */
  public static function update($entry) {
    try {
      // db_update()...->execute() returns the number of rows updated.
      $count = db_update('nc_social')
        ->fields($entry)
        ->condition('sn_id', $entry['sn_id'])
        ->execute();
    }
    catch (\Exception $e) {
      drupal_set_message(t('db_update failed. Message = %message, query= %query', array(
          '%message' => $e->getMessage(),
          '%query' => $e->query_string,
        )
      ), 'error');
    }
    return $count;
  }

  /**
   * Delete an entry from the database.
   *
   * @param array $entry
   *   An array containing at least the person identifier 'pid' element of the
   *   entry to delete.
   *
   * @see db_delete()
   */
  public static function delete($entry) {
    db_delete('nc_social')
      ->condition('sn_id', $entry['sn_id'])
      ->execute();
  }

  /**
   * Read from the database using a filter array.
   *
   * The standard function to perform reads was db_query(), and for static
   * queries, it still is.
   *
   * db_query() used an SQL query with placeholders and arguments as parameters.
   *
   * Drupal DBTNG provides an abstracted interface that will work with a wide
   * variety of database engines.
   *
   * db_query() is deprecated except when doing a static query. The following is
   * perfectly acceptable in Drupal 8. See
   * @link http://drupal.org/node/310072 the handbook page on static queries @endlink
   *
   * @code
   *   // SELECT * FROM {dbtng_example} WHERE uid = 0 AND name = 'John'
   *   db_query(
   *     "SELECT * FROM {dbtng_example} WHERE uid = :uid and name = :name",
   *     array(':uid' => 0, ':name' => 'John')
   *   )->execute();
   * @endcode
   *
   * But for more dynamic queries, Drupal provides the db_select()
   * API method, so there are several ways to perform the same SQL query. See
   * the
   * @link http://drupal.org/node/310075 handbook page on dynamic queries. @endlink
   * @code
   *   // SELECT * FROM {dbtng_example} WHERE uid = 0 AND name = 'John'
   *   db_select('dbtng_example')
   *     ->fields('dbtng_example')
   *     ->condition('uid', 0)
   *     ->condition('name', 'John')
   *     ->execute();
   * @endcode
   *
   * Here is db_select with named placeholders:
   * @code
   *   // SELECT * FROM {dbtng_example} WHERE uid = 0 AND name = 'John'
   *   $arguments = array(':name' => 'John', ':uid' => 0);
   *   db_select('dbtng_example')
   *     ->fields('dbtng_example')
   *     ->where('uid = :uid AND name = :name', $arguments)
   *     ->execute();
   * @endcode
   *
   * Conditions are stacked and evaluated as AND and OR depending on the type of
   * query. For more information, read the conditional queries handbook page at:
   * http://drupal.org/node/310086
   *
   * The condition argument is an 'equal' evaluation by default, but this can be
   * altered:
   * @code
   *   // SELECT * FROM {dbtng_example} WHERE age > 18
   *   db_select('dbtng_example')
   *     ->fields('dbtng_example')
   *     ->condition('age', 18, '>')
   *     ->execute();
   * @endcode
   *
   * @param array $entry
   *   An array containing all the fields used to search the entries in the
   *   table.
   *
   * @return object
   *   An object containing the loaded entries if found.
   *
   * @see db_select()
   * @see db_query()
   * @see http://drupal.org/node/310072
   * @see http://drupal.org/node/310075
   */
  public static function load($entry = array(), $getAll = false, $page = 0, $num_per_page = 50, $orderby = array()) {
    $offset = $num_per_page * $page;

    $database = \Drupal::database();
    $query = $database->select('nc_social', 'sn');
    $query->fields('sn');

    foreach ($entry as $field => $value) {
      $query->condition($field, $value);
    }

    if(count($orderby) > 0){
      $query->orderBy($orderby['field'], $orderby['direction']);
    }

    if($getAll === true)
      return $query->countQuery()->execute()->fetchField();
    else
      return $query->range($offset, $num_per_page)->execute()->fetchAll();
  }

}
