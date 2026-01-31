<?php

function generateSovereignActions($entity, $risk) {

  if ($risk > 80) {
    return [
      'action_type' => 'national_alert',
      'command' => 'Immediate multi-agency intervention required',
      'confidence' => 0.9
    ];
  }

  if ($risk > 50) {
    return [
      'action_type' => 'strategic_monitoring',
      'command' => 'Escalate monitoring and deploy edge verification',
      'confidence' => 0.7
    ];
  }

  return null;
}
