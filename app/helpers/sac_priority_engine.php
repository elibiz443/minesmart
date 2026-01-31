<?php

function computePriority($risk, $impact, $connectivity) {
  return ($risk * 0.5) + ($impact * 0.3) + ($connectivity * 0.2);
}
