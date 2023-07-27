<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for News Release experts, contacts, and electronic press kit fields.
 * 
 * @MigrateSource(id = "uahs_news_release_main_content")
 */
class NewsReleaseMainContent extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('fdfe', 'field_experts_value', 'field_experts');
        $query->addField('fdfc', 'field_contact_value', 'field_contact');
        $query->addField('fdfepkl', 'field_electronic_press_kit_link_url', 'field_electronic_press_kit_link');
        $query->addExpression("GROUP_CONCAT(fdfrns.field_related_news_stories_title SEPARATOR '|')", 'field_related_news_stories_title');
        $query->addExpression('GROUP_CONCAT(fdfrns.field_related_news_stories_url)', 'field_related_news_stories_url');
        $query->addJoin('LEFT OUTER', 'field_data_field_experts', 'fdfe', 'fdfe.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_contact', 'fdfc', 'fdfc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_electronic_press_kit_link', 'fdfepkl', 'fdfepkl.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_related_news_stories', 'fdfrns', 'fdfrns.entity_id = n.nid');
        $query->condition('n.type', 'news_release', '=');
        $query->condition('n.status', '1', '=');
        $query->groupBy('n.nid');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'field_experts' => $this->t('Experts'),
            'field_contact' => $this->t('Contact'),
            'field_electronic_press_kit_link' => $this->t('Electronic Press Kit Link'),
            'field_related_news_stories_title' => $this->t('Related Story Content Title'),
            'field_related_news_stories_url' => $this->t('Related Story Content URL'),
            'field_related_news_stories' => $this->t('Related Story Content')
        ];
    }

    public function getIds() {
        return [
            'nid' => [
                'type' => 'integer',
                'alias' => 'n'
            ]
        ];
    }

    public function prepareRow(Row $row) {
        $experts = $row->getSourceProperty('field_experts');
        $experts_card_title = $experts ? 'Our Experts' : NULL;
        $experts_card_body = $experts ? $experts : NULL;
        $experts_card_body_format = $experts ? 'az_standard' : NULL;
        $row->setSourceProperty('experts_card_title', $experts_card_title);
        $row->setSourceProperty('experts_card_body', $experts_card_body);
        $row->setSourceProperty('experts_card_body_format', $experts_card_body_format);

        $contact = $row->getSourceProperty('field_contact');
        $contact_card_title = $contact ? 'Contact' : NULL;
        $contact_card_body = $contact ? $contact : NULL;
        $contact_card_body_format = $contact ? 'az_standard' : NULL;
        $row->setSourceProperty('contact_card_title', $contact_card_title);
        $row->setSourceProperty('contact_card_body', $contact_card_body);
        $row->setSourceProperty('contact_card_body_format', $contact_card_body_format);

        $press_kit = $row->getSourceProperty('field_electronic_press_kit_link');
        $press_kit_card_title = $press_kit ? 'Electronic Press Kit' : NULL;
        if ($press_kit) {
            $press_kit_card_body = '<a type="button" class="btn btn-red" href="' . $press_kit . '">View Electronic Press Kit</a>';
        } else {
            $press_kit_card_body = NULL;
        }
        $press_kit_card_body_format = $press_kit ? 'az_standard' : NULL;
        $row->setSourceProperty('press_kit_card_title', $press_kit_card_title);
        $row->setSourceProperty('press_kit_card_body', $press_kit_card_body);
        $row->setSourceProperty('press_kit_card_body_format', $press_kit_card_body_format);

        $related_story_title = $row->getSourceProperty('field_related_news_stories_title');
        $related_story_url = $row->getSourceProperty('field_related_news_stories_url');
        if ($related_story_url) {
            $related_story_card_title = 'Related Stories';
            $related_story_titles = explode('|', $related_story_title);
            $related_story_urls = explode(',', $related_story_url);
            $related_story_card_body = '';
            for ($i = 0; $i < count($related_story_urls); $i++) {
                $story_title = $related_story_titles[$i];
                $story_url = $related_story_urls[$i];
                $related_story_card_body .= '<p><a href="' . $story_url . '">' . $story_title . '</a></p>';
            }
            $related_story_card_body_format = 'az_standard';
        } else {
            $related_story_card_title = NULL;
            $related_story_card_body = NULL;
            $related_story_card_body_format = NULL;
        }
        $row->setSourceProperty('related_stories_card_title', $related_story_card_title);
        $row->setSourceProperty('related_stories_card_body', $related_story_card_body);
        $row->setSourceProperty('related_stories_card_body_format', $related_story_card_body_format);
        
        return parent::prepareRow($row);
    }
}