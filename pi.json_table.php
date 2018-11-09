<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'JSON Table',
  'pi_version' => '0.0.1',
  'pi_author' => 'Andy Hebrank',
  'pi_author_url' => 'https://github.com/ahebrank',
  'pi_description' => 'Output ExpressionEngine table data in JSON format.',
  'pi_usage' => '
{exp:json_table table="seolite_content"}

{exp:json_table table="seolite_content" entry_id="99"}
',
);

/**
 * Export a SQL table as JSON.
 */
class Json_table {

  /**
   * Constructor.
   */
  public function __construct() {
    $table = ee()->TMPL->fetch_param('table');
    $entry_id = ee()->TMPL->fetch_param('entry_id');

    if (!$table) {
      return "Need a table specified.";
    }

    ee()->db->select('*')->from($table . ' t');
    if ($entry_id) {
      ee()->db->where_in('t.entry_id', $entry_id);
    }

    $query = ee()->db->get();
    $rows = $query->result_array();
    $query->free_result();

    return $this->respond($rows);
  }

  /**
   * Create a JSON response.
   */
  protected function respond(array $response) {
    ee()->load->library('javascript');

    $response = function_exists('json_encode')
      ? json_encode($response)
      : ee()->javascript->generate_json($response, TRUE);

    @header('Content-Type: application/json');
    exit($response);
  }

}
