<?php

namespace Darake\SculpinRelatedPostsBundle;

use Sculpin\Core\Sculpin;
use Sculpin\Core\Event\SourceSetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Sculpin\Core\Permalink\SourcePermalinkFactory;


class RelatedPostsGenerator implements EventSubscriberInterface
{
    protected $parmalinkFactory;
    protected $maxPerPage;
    protected $taxonomyType;

    protected $defaultMaxPerPage = 5;
    protected $defaultTaxonomyType = "tags";

    public function __construct(SourcePermalinkFactory $parmalinkFactory, $maxPerPage, $taxonomyType)
    {
        $this->parmalinkFactory = $parmalinkFactory;
        $this->maxPerPage = $maxPerPage;
        $this->taxonomyType = $taxonomyType;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Sculpin::EVENT_BEFORE_RUN => array('beforeRun', 100),
        );
    }

    public function beforeRun(SourceSetEvent $sourceSetEvent)
    {
        $sourceSet = $sourceSetEvent->sourceSet();
        $updateSources = $sourceSet->updatedSources();
        $allSources = $sourceSet->allSources();

        $maxPerPage = $this->maxPerPage ?: $this->defaultMaxPerPage;
        $taxonomyType = $this->taxonomyType ?: $this->defaultTaxonomyType;

        $tagsMap = [];

        foreach ($updateSources as $source) {
            if ($sourceTags = $source->data()->get($taxonomyType)) {
                foreach ($sourceTags as $tag) {
                    $tagsMap[$tag][] = $source->sourceId();
                }
            }
        }

        foreach ($updateSources as $source) {
            $tagMatch = array();

            if (!$sourceTags = $source->data()->get($taxonomyType)) {
                continue;
            }

            foreach ($sourceTags as $tag) {
                $tagMatch = array_merge($tagMatch, $tagsMap[$tag]);
            }
            $tagMatchCount = array_count_values($tagMatch);

            unset($tagMatchCount[$source->sourceid()]);
            asort($tagMatchCount);

            $relatedSources = [];
            foreach ($tagMatchCount as $match => $count) {
                if (count($relatedSources) == $maxPerPage) {
                    break;
                }

                $relatedSource = $allSources[$match];

                if (!$relatedSource->data()->get('draft')) {
                    $relatedSources[] = [
                        "title" => $relatedSource->data()->get("title"),
                        "source" => $relatedSource,
                        "data" => $relatedSource->data(),
                    ];
                }
            }

            $source->data()->set('related', $relatedSources);
        }
    }
}
