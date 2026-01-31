<?php

function computeCollapseProbability($risk, $connectivity) {
  return min(1, ($risk / 100) * $connectivity);
}
